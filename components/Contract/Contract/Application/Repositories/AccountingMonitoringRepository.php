<?php
namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AccountingMonitoringRepositoryInterface;

class AccountingMonitoringRepository implements AccountingMonitoringRepositoryInterface
{
    public function list(
        User $user,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null,
        ?array $filter = null
    ) {
        return Contract::query()
            ->whereNull('parent_id')
            ->whereNull('archived_at')
            ->with('workfield', 'enterprise')
            ->where(function ($query) use ($user) {
                return $query
                    ->whereHas('parties', function ($query) use ($user) {
                        return $query->whereHas('enterprise', function ($query) use ($user) {
                            return $query->whereIn('id', $user->enterprises->pluck('id'));
                        });
                    })
                    ->orWhereHas('enterprise', function ($query) use ($user) {
                        return $query->whereIn('id', $user->enterprises->pluck('id'));
                    });
            })->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
                return $query->filterEnterprise($enterprises);
            })->when($filter['work_fields'] ?? null, function ($query, $work_fields) {
                return $query->filterWorkFields($work_fields);
            })->latest()->paginate($page ?? 25);
    }

    public function getSearchableAttributes(): array
    {
        return [
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_EXTERNAL_IDENTIFIER =>
                'components.contract.contract.application.views.contract._table_head.contract_external_identifier',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_NAME =>
                'components.contract.contract.application.views.contract._table_head.name',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_WORKFIELD_EXTERNAL_IDENTIFIER =>
                'components.contract.contract.application.views.contract._table_head.workfield_external_identifier',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_NUMBER =>
                'components.contract.contract.application.views.contract._table_head.contract_number',
            ContractEntityInterface::SEARCHABLE_ATTRIBUTE_CONTRACT_PARTY_ENTERPRISE_NAME =>
                'components.contract.contract.application.views.contract._table_head.contract_party_enterprise_name',
        ];
    }

    public function getWorkfieldName($contract)
    {
        return !is_null($contract->getWorkfield()) ? $contract->getWorkfield()->getDisplayName() : "n/a";
    }

    public function getVendor($contract)
    {
        $contract_party = ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', false)->orderBy('order', 'asc')->get()->filter(function ($party) use ($contract) {
            if ($party->getEnterprise()) {
                return $party->getEnterprise()->id != $contract->getEnterprise()->id;
            } else {
                return false;
            }
        })->first();

        return is_null($contract_party) || is_null($contract_party->getEnterprise()->name) ?
            'n/a' :
            $contract_party->getEnterprise()->name;
    }

    public function getSignature($contract)
    {
        $contract_party = ContractParty::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->where('is_validator', false)
        ->orderBy('order', 'asc')
        ->where('order', 2)
        ->latest()
        ->first();

        return !is_null($contract_party) ? $contract_party->getSignedAt() : 'n/a';
    }

    public function getGuaranteedHoldback($contract)
    {
        return ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'retenue_garantie');
        })->first()->value ?? 'n/a';
    }

    public function getGuaranteedHoldbackAmount($contract)
    {
        $amount = 0;

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $amount += $invoice->getAmountGuaranteedHoldback();
        }

        return $amount;
    }

    public function getGuaranteedHoldbackDepositNumber($contract)
    {
        $list = [];

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $list[] = $invoice->getDepositGuaranteedHoldbackNumber();
        }

        return is_null($list) ? 'n/a' : implode(', ', $list);
    }

    public function getGoodEnd($contract)
    {
        return ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'garantie_bonne_fin');
        })->first()->value ?? 'n/a';
    }

    public function getGoodEndAmount($contract)
    {
        $amount = 0;

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $amount += $invoice->getAmountGoodEnd();
        }

        return $amount;
    }

    public function getGoodEndDeposit($contract)
    {
        $list = [];

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $list[] = $invoice->getDepositGoodEndNumber();
        }

        return is_null($list) ? 'n/a' : implode(', ', $list);
    }

    public function getAmountBeforeTaxes($contract)
    {
        $variable = ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'montant_du_marche');
        })->first();
        $value = isset($variable) ? $variable->value : 0;

        return isset($value) && is_numeric($value) ? $value : 0;
    }

    public function getAmountBeforeTaxesInvoiced($contract)
    {
        $amount = 0;

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $amount += $invoice->getInvoiceAmountBeforeTaxes();
        }

        return $amount;
    }

    public function getAmountOfTaxesInvoiced($contract)
    {
        $amount = 0;

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $amount += $invoice->getInvoiceAmountOfTaxes();
        }

        return $amount;
    }

    public function getAmountOfRemainsToBeBilled($contract)
    {
        $amount_before_taxes = 0;

        $contract_amount = ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'montant_du_marche');
        })->first()->value ?? 0;

        $invoices = CaptureInvoice::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->get();

        foreach ($invoices as $invoice) {
            $amount_before_taxes += $invoice->getInvoiceAmountBeforeTaxes();
        }

        if (is_numeric($contract_amount) && is_numeric($amount_before_taxes)) {
            return ($contract_amount - $amount_before_taxes);
        } else {
            return 0;
        }
    }

    public function getPayment($contract)
    {
        return ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->id);
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('name', 'sous_traitant_paye_par');
        })->first()->value ?? 'n/a';
    }
}
