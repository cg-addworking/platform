<?php

namespace Components\Enterprise\Export\Application\Builders;

use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PartnershipCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0  => "entreprise_id",
        1  => "raison_sociale",
        2  => "siret",
        3  => "nom_client",
        4  => "actif_avec_ce_client",
        5  => "nombre_de_contrat",
        6  => "nombre_de_facture",
        7  => "volume_de_facture_inbound",
        8  => "moyenne_de_facture_inbound_sur_6_mois",
        9  => "date_de_début_de_relation",
        10 => "a_un_passwork_generique",
        11 => "a_recu_une_proposition_de_mission",
    ];

    public function append(Model $model): int
    {
        $result = true;

        foreach ($this->normalize($model) as $value) {
            $result &= parent::fputcsv($value);
        }
        
        return $result;
    }

    protected function normalize(Model $model): array
    {
        $content = [];

        foreach ($model->customers()->get() as $customer) {
            $content[] = [
                0  => $model->id,
                1  => $model->legalForm->name." - ".$model->name,
                2  => $model->identification_number,
                3  => $customer->name,
                4  => $model->vendorInActivityWithCustomer($customer)? "Oui": "Non",
                5  => $this->countContractsBetween($model, $customer),
                6  => $this->countInboundInvoicesBetween($model, $customer),
                7  => $this->sumInboudInvoicesAmountBetween($model, $customer),
                8  => $this->getAverageAmountBeforeTaxesOfInboundInvoicesOnLatestSixMonths($model, $customer),
                9  => $this->getStartsAtPartnershipWith($model, $customer),
                10 => $this->hasPasswork($model, $customer) ? "Oui" : "Non",
                11 => $this->hasMissionProposalOf($model, $customer) ? "Oui" : "Non",
            ];
        }

        return $content;
    }

    private function countContractsBetween(Enterprise $model, Enterprise $customer): int
    {
        return Contract::whereHas('contractParties', fn($q) => $q->whereEnterprise($model))
            ->whereHas('enterprise', fn($q) => $q->whereId($customer->id))
            ->count();
    }

    private function countInboundInvoicesBetween(Enterprise $model, Enterprise $customer): int
    {
        return InboundInvoice::whereHas('enterprise', fn($q) => $q->whereId($model->id))
            ->whereHas('customer', fn($q) => $q->whereId($customer->id))->count();
    }

    private function sumInboudInvoicesAmountBetween(Enterprise $model, Enterprise $customer): float
    {
        return InboundInvoice::whereHas('enterprise', fn($q) => $q->whereId($model->id))
            ->whereHas('customer', fn($q) => $q->whereId($customer->id))
            ->sum('amount_before_taxes');
    }

    private function getAverageAmountBeforeTaxesOfInboundInvoicesOnLatestSixMonths(
        Enterprise $model,
        Enterprise $customer
    ): float {
        $invoices = InboundInvoice::whereHas('enterprise', fn($q) => $q->whereId($model->id))
            ->whereHas('customer', fn($q) => $q->whereId($customer->id))
            ->whereBetween('created_at', [Carbon::today()->subMonths(6), Carbon::today()])->get();

        return $invoices->count() ? round($invoices->sum('amount_before_taxes') / $invoices->count(), 2) : 0 ;
    }

    private function getStartsAtPartnershipWith(Enterprise $model, Enterprise $customer): ?\DateTime
    {
        $customer = $model->customers()->find($customer);

        return isset($customer, $customer->pivot) ? new Carbon($customer->pivot->activity_starts_at) : null;
    }

    private function hasPasswork(Enterprise $model, Enterprise $customer): bool
    {
        return Passwork::whereHas('customer', fn($q) => $q->whereId($customer->id))
            ->whereHasMorph('passworkable', [Enterprise::class, User::class], fn($q) => $q->whereId($model->id))
            ->exists();
    }

    private function hasMissionProposalOf(Enterprise $model, Enterprise $customer): bool
    {
        return Proposal::whereHas('vendor', fn($q) => $q->whereId($model->id))
            ->whereHas('offer', fn($q) => $q->whereHas('customer', fn($q) => $q->whereId($customer->id)))
            ->exists();
    }
}
