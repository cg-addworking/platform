<?php
namespace Components\Billing\PaymentOrder\Tests\Acceptance\GeneratePaymentOrderFile;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderFileRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderItemRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Application\Repositories\VatRateRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderIsEmptyException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderIsNotInPendingStatusException;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\GeneratePaymentOrderFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratePaymentOrderFileContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $outboundInvoiceRepository;
    private $inboundInvoiceRepository;
    private $vatRateRepository;
    private $userRepository;
    private $ibanRepository;
    private $paymentOrderRepository;
    private $paymentOrderItemRepository;
    private $outboundInvoiceItemRepository;
    private $paymentOrderFileRepository;

    public function __construct()
    {
        parent::setUp();

        $this->deadlineRepository            = new DeadlineRepository;
        $this->enterpriseRepository          = new EnterpriseRepository;
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository;
        $this->vatRateRepository             = new VatRateRepository;
        $this->inboundInvoiceRepository      = new InboundInvoiceRepository;
        $this->userRepository                = new UserRepository;
        $this->ibanRepository                = new IbanRepository;
        $this->paymentOrderRepository        = new PaymentOrderRepository;
        $this->paymentOrderItemRepository    = new PaymentOrderItemRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
        $this->paymentOrderFileRepository    = new PaymentOrderFileRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise;
            $enterprise->fill([
                'name' => $item['name'],
                'identification_number' => $item['siret'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor']
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->save();

            $enterprise->addresses()->attach(
                factory(Address::class)->create()
            );

            $enterprise->phoneNumbers()->attach(
                factory(PhoneNumber::class)->create()
            );
        }
    }

    /**
     * @Given /^les partenariats suivants existent$/
     */
    public function lesPartenariatsSuivantsExistent(TableNode $partnerships)
    {
        foreach ($partnerships as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $vendor   = $this->enterpriseRepository->findBySiret($item['siret_vendor']);

            $customer->vendors()->attach($vendor);
        }
    }

    /**
     * @Given /^les ibans suivants existent$/
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = factory(Iban::class)->make(['status' => "approved"]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $iban->enterprise()->associate($enterprise);
            $iban->save();
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = factory(User::class)->create([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email'    => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^les echeances de paiement suivantes existent$/
     */
    public function lesEcheancesDePaiementSuivantesExistent(TableNode $deadlines)
    {
        foreach ($deadlines as $item) {
            factory(DeadlineType::class)->create([
                'name'         => $item['name'],
                'display_name' => $item['display_name'],
                'value'        => $item['value'],
            ]);
        }
    }

    /**
     * @Given /^les taux de tva suivants existent$/
     */
    public function lesTauxDeTvaSuivantsExistent(TableNode $vat_rates)
    {
        foreach ($vat_rates as $item) {
            factory(VatRate::class)->create([
                'name'         => $item['name'],
                'display_name' => $item['display_name'],
                'value'        => $item['value'],
            ]);
        }
    }

    /**
     * @Given /^les factures outbound suivantes existent$/
     */
    public function lesFacturesOutboundSuivantesExistent(TableNode $outbound_invoices)
    {
        foreach ($outbound_invoices as $item) {
            $invoice = factory(OutboundInvoice::class)->make([
                'month'  => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
            ]);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $invoice->save();
        }
    }

    /**
     * @Given /^les factures inbound suivantes existent$/
     */
    public function lesFacturesInboundSuivantesExistent(TableNode $inbound_invoices)
    {
        foreach ($inbound_invoices as $item) {
            $invoice = factory(InboundInvoice::class)->make([
                'month'  => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
            ]);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $invoice->customer()->associate($customer->id);

            $invoice->save();
        }
    }

    /**
     * @Given /^les lignes factures inbound suivantes existent$/
     */
    public function lesLignesFacturesInboundSuivantesExistent(TableNode $inbound_items)
    {
        foreach ($inbound_items as $item) {
            $invoiceItem = factory(InboundInvoiceItem::class)->make([
                'label'      => $item['label'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

            $invoice = $this->inboundInvoiceRepository->findBy($item['siret'], $item['number'], $item['month']);
            $invoiceItem->inboundInvoice()->associate($invoice);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $invoiceItem->vatRate()->associate($vatRate);

            $invoiceItem->save();
        }
    }

    /**
     * @Given /^les lignes factures outbound suivantes existent$/
     */
    public function lesLignesFacturesOutboundSuivantesExistent(TableNode $outbound_items)
    {
        foreach ($outbound_items as $item) {
            $invoiceItem = factory(OutboundInvoiceItem::class)->make([
                'label'      => $item['label'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $invoiceItem->outboundInvoice()->associate($outboundInvoice);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $invoiceItem->vatRate()->associate($vatRate);

            $inboundInvoice = $this->inboundInvoiceRepository
                ->findBy($item['siret_vendor'], $item['inbound_number'], $item['month']);
            $inboundInvoice->outboundInvoice()->associate($outboundInvoice);
            $inboundInvoice->save();

            $inboundInvoiceItem = $inboundInvoice->items()->first();
            $invoiceItem->inboundInvoiceItem()->associate($inboundInvoiceItem->id);

            $invoiceItem->save();
        }
    }

    /**
     * @Given /^les ordres de paiement suivants existent$/
     */
    public function lesOrdresDePaiementSuivantsExistent(TableNode $payment_orders)
    {
        foreach ($payment_orders as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);

            $paymentOrder = factory(PaymentOrder::class)->make([
                'number'        => $item['number'],
                'customer_name' => $customer->name,
                'status'        => $item['status']
            ]);

            $paymentOrder->enterprise()->associate($customer);
            $paymentOrder->save();
        }
    }

    /**
     * @Given /^les lignes d\'ordre de paiement suivantes existent$/
     */
    public function lesLignesDOrdreDePaiementSuivantesExistent(TableNode $payment_order_items)
    {
        foreach ($payment_order_items as $item) {
            $paymentOrderItem = factory(PaymentOrderItem::class)->make([
                'number'        => $item['number']
            ]);

            $paymentOrder = $this->paymentOrderRepository->findbyNumber($item['payment_order_number']);
            $paymentOrderItem->paymentOrder()->associate($paymentOrder);

            $inboundInvoice = $this->inboundInvoiceRepository->findbyNumber($item['inbound_number']);
            $paymentOrderItem->inboundInvoice()->associate($inboundInvoice);
            $paymentOrderItem->setOutboundInvoice($inboundInvoice->outboundInvoice);

            $iban = $this->ibanRepository->findByEnterprise($inboundInvoice->enterprise);
            $paymentOrderItem->iban()->associate($iban);
            $paymentOrderItem->setEnterpriseName($iban->enterprise->name);
            $paymentOrderItem->setEnterpriseIban($iban->iban);
            $paymentOrderItem->setEnterpriseBic($iban->bic);

            $paymentOrderItem->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de generer le fichier de l\'ordre de paiement numero "([^"]*)"$/
     */
    public function jessaieDeGenererLeFichierDeLordreDePaiementNumero(int $number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $payment_order = $this->paymentOrderRepository->findByNumber($number);

        try {
            $this->response = (new GeneratePaymentOrderFile(
                $this->userRepository,
                $this->paymentOrderRepository,
                $this->paymentOrderItemRepository,
                $this->paymentOrderFileRepository,
            ))->handle($auth_user, $payment_order);
        } catch (\Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le fichier de l\'ordre de paiement est genere$/
     */
    public function leFichierDeLordreDePaiementEstGenere()
    {
        $this->assertTrue($this->response);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'ordre de paiement n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLordreDePaiementNexistePas()
    {
        $this->assertContainsEquals(
            PaymentOrderNotFoundException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'ordre de paiement n\'a pas de lignes$/
     */
    public function uneErreurEstLeveeCarLordreDePaiementNaPasDeLignes()
    {
        $this->assertContainsEquals(
            PaymentOrderIsEmptyException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'ordre de paiement n\'est pas au statut en attente$/
     */
    public function uneErreurEstLeveeCarLordreDePaiementNestPasAuStatutEnAttente()
    {
        $this->assertContainsEquals(
            PaymentOrderIsNotInPendingStatusException::class,
            $this->errors
        );
    }
}
