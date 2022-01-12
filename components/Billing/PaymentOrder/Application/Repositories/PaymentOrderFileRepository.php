<?php
namespace Components\Billing\PaymentOrder\Application\Repositories;

use App\Models\Addworking\Common\File;
use Carbon\Carbon;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderFileRepositoryInterface;

class PaymentOrderFileRepository implements PaymentOrderFileRepositoryInterface
{
    const GROUPING = "MIXD";
    const METHOD = "TRF";
    const TYPE_CODE = "SEPA";

    private $paymentOrderRepository;

    public function __construct()
    {
        $this->paymentOrderRepository = new PaymentOrderRepository;
    }

    public function generate(PaymentOrderInterface $payment_order)
    {
        $groupHeader = $this->groupHeader($payment_order);
        $paymentInformation = $this->paymentInformation($payment_order);

        foreach ($payment_order->getItems() as $item) {
            $transferTransactionInformations[] = $this->transferTransactionInformations($item);
        }

        $view = view(
            'payment_order::payment_order.file.xml',
            @compact('groupHeader', 'paymentInformation', 'transferTransactionInformations')
        )->render();

        $file = File::from($view)
            ->fill(['mime_type' => "text/xml"])
            ->name("/{$payment_order->getReference()}_".uniqid().".xml")
            ->saveAndGet();

        $payment_order->setFile($file->id);
        $payment_order->save();

        return $this->paymentOrderRepository->hasFile($payment_order);
    }

    private function groupHeader(PaymentOrder $payment_order)
    {
        $number = str_pad($payment_order->getNumber(), 20, "0", STR_PAD_LEFT);


        return [
            'messageIdentification' => "ADDWORKING-PAY-{$number}",
            'creationDateTime' => Carbon::now()->format('Y-m-d\TH:i:s'),
            'numberOfTransactions' => count($payment_order->getItems()),
            'controlSum' => $payment_order->getTotalAmount(),
            'grouping' => self::GROUPING,
            'initiatingParty' => [
                'name' => substr($payment_order->getDebtorName(), 0, 70),
            ],
        ];
    }

    private function paymentInformation(PaymentOrder $payment_order)
    {
        return [
            'paymentInformationIdentification' => $payment_order->getReference(),
            'paymentMethod' => self::METHOD,
            'paymentTypeInformation' => ['serviceLevel' => ['code' => self::TYPE_CODE]],
            'requestedExecutionDate' => $payment_order->getExecutedAt()->format('Y-m-d'),
            'debtor' => ['name' => substr($payment_order->getDebtorName(), 0, 70)],
            'debtorAccount' => [
                'identification' => [
                    'iban' => str_replace(' ', '', strtoupper($payment_order->getDebtorIban())),
                ],
            ],
            'debtorAgent' => [
                'financialInstitutionIdentification' => [
                    'bic' => str_replace(' ', '', strtoupper($payment_order->getDebtorBic())),
                ],
            ],
            'ultimateDebtor' => ['name' => substr($payment_order->getCustomerName(), 0, 70)]
        ];
    }

    private function transferTransactionInformations(PaymentOrderItem $payment_order_item)
    {
        return [
            'paymentIdentification' => [
                'instructionIdentification' => $payment_order_item->getReference(),
                'endToEndIdentification' => $payment_order_item->getReference(),
            ],
            'amount' => ['instructedAmount' => $payment_order_item->getAmount()],
            'creditorAgent' => [
                'financialInstitutionIdentification' => [
                    'bic' => str_replace(' ', '', $payment_order_item->getEnterpriseBic()),
                ],
            ],
            'creditor' => ['name' => substr($payment_order_item->getEnterpriseName(), 0, 70)],
            'creditorAccount' => [
                'identification' => [
                    'iban' => str_replace(' ', '', strtoupper($payment_order_item->getEnterpriseIban())),
                ],
            ],
            'remittanceInformation' => ['unstructured' => $payment_order_item->getReferenceForVendor()]
        ];
    }
}
