<?php

namespace Components\Billing\PaymentOrder\Application\Loaders;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentOutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use stdClass;
use RuntimeException;

class ReceivedPaymentCsvLoader extends CsvLoader
{
    protected $flags = CsvLoader::IGNORE_FIRST_LINE | CsvLoader::VERBOSE;
    protected const RECEIPT = 'encaissement';

    public function headers(): array
    {
        return [
            'Type de facture',
            'Catégorie détaillée',
            'Catégorie',
            'Intitulé',
            'Montant TTC',
            'Date de règlement',
            'Date de facturation',
            'Identifiant unique de la facture',
            'Compte bancaire',
            'Mémo',
            'Entreprise',
            'Devise',
            'Réconcilié',
            'Ignorée',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        foreach ($this->headers() as $key) {
            $item->$key = ($str = trim($item->$key, " \t\n\r\x0B")) ? $str : null;

            if (strtolower($item->$key) === 'vrai') {
                $item->$key = true;
            }

            if (strtolower($item->$key) === 'faux') {
                $item->$key = false;
            }
        }

        $item->{"Type de facture"} = strtolower($item->{"Type de facture"});
        $item->{"Montant TTC"} = floatval(str_replace([',', ' '], ['.', ''], $item->{"Montant TTC"}));
        $item->{"Date de règlement"} = Carbon::createFromFormat('m/d/Y', $item->{"Date de règlement"})->startOfDay();
        $item->{"Compte bancaire"} = preg_replace('/\s+/', ' ', $item->{"Compte bancaire"});

        $rules = $this->getValidationRules();

        Validator::make((array) $item, $rules)->validate();

        return $item;
    }

    protected function getValidationRules(): array
    {
        return [
            'Type de facture' => 'required',
            'Catégorie détaillée' => 'nullable',
            'Catégorie' => 'nullable',
            'Intitulé' => 'required',
            'Montant TTC' => 'required',
            'Date de règlement' => 'nullable',
            'Date de facturation' => 'nullable',
            'Identifiant unique de la facture' => 'required',
            'Compte bancaire' => 'required',
            'Mémo' => 'nullable',
            'Entreprise' => 'nullable',
            'Devise' => 'nullable',
            'Réconcilié' => 'required',
            'Ignorée' => 'nullable',
        ];
    }

    public function import(stdClass $item): bool
    {
        if ($item->{"Type de facture"} !== self::RECEIPT || $item->{"Réconcilié"} === false) {
            return false;
        }

        $existing_received_payment = ReceivedPayment::where('agicap_id', $item->{"Identifiant unique de la facture"})
            ->first();

        if (! is_null($existing_received_payment)) {
            return false;
        }

        //finding the string with outbound invoice & enterprise numbers
        $sequence = $this->findSequenceFrom($item->{"Intitulé"});

        //finding the outbound invoice and enterprise
        $elements = $this->findElementsFrom($sequence);

        $outbound_invoice = $elements['outbound_invoice'];
        $enterprise = $elements['enterprise'];

        $addworking = Enterprise::where('name', "ADDWORKING")->first();
        $iban = $addworking->ibans->firstWhere('label', $item->{"Compte bancaire"});

        if (is_null($iban)) {
            throw new RuntimeException("no iban found!");
        }

        $received_payment = $this->createReceivedPaymentFrom($item, $outbound_invoice, $enterprise, $iban);

        return $received_payment->exists;
    }

    public function findSequenceFrom(string $title)
    {
        if (! Str::contains(strtolower($title), strtolower('CPS1'))) {
            throw new RuntimeException("data is missing the CPS1 prefix");
        }

        $pattern = "#CPS1(.*?)(\w+)#";
        //should we worry about finding cps1 or cPs1 instead of CPS1 ?
        //$pattern = "#[cC][pP][sS]1(.*?)(\w+)#";

        if (preg_match($pattern, $title, $matches)) {
            return $matches[0];
        }

        throw new RuntimeException("no data found");
    }

    public function findElementsFrom(string $sequence)
    {
        //checking if we have a formed sequence
        if (! Str::contains($sequence, '_')) {
            throw new RuntimeException("sequence is malformed");
        }

        $exploded = explode('_', $sequence);
        $enterprise = Enterprise::where('number', $exploded[1])->first();
        $outbound_invoice = OutboundInvoice::where('number', $exploded[2])->first();

        //checking if we have found the enterprise and the outbound invoice
        if (is_null($enterprise) || is_null($outbound_invoice)) {
            throw new RuntimeException("enterprise or outbound not found");
        }

        //checking if we have to right duo
        if ($outbound_invoice->enterprise->id !== $enterprise->id) {
            throw new RuntimeException("elements are not in relation");
        }

        return [
            'enterprise' => $enterprise,
            'outbound_invoice' => $outbound_invoice,
        ];
    }

    protected function createReceivedPaymentFrom(
        StdClass $item,
        OutboundInvoice $outbound_invoice,
        Enterprise $enterprise,
        Iban $iban
    ): ReceivedPayment {
        $received_payment = App::make(ReceivedPaymentRepository::class)->make();
        $received_payment->setEnterprise($enterprise);
        $received_payment->setIban($iban);
        $received_payment->setNumber();
        $received_payment->setBankReferencePayment($item->{"Mémo"});
        $received_payment->setIbanReference($iban->iban);
        $received_payment->setBicReference($iban->bic);
        $received_payment->setAmount($item->{"Montant TTC"});
        $received_payment->setReceivedAt($item->{"Date de règlement"});
        $received_payment->setAgicapId($item->{"Identifiant unique de la facture"});
        $payment = App::make(ReceivedPaymentRepository::class)->save($received_payment);

        $relation = App::make(ReceivedPaymentOutboundInvoiceRepository::class)->make();
        $relation->setOutboundInvoice($outbound_invoice);
        $relation->setReceivedPayment($payment);
        App::make(ReceivedPaymentOutboundInvoiceRepository::class)->save($relation);

        return $payment;
    }
}
