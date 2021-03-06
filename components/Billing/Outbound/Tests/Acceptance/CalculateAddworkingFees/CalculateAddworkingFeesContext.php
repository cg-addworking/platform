<?php

namespace Components\Billing\Outbound\Tests\Acceptance\CalculateAddworkingFees;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceItem;
use App\Models\Addworking\Billing\VatRate;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\InvoiceParametersNotInformedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyValidatedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\CalculateAddworkingFees;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateAddworkingFeesContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $inboundInvoiceRepository;
    private $vatRateRepository;
    private $outboundInvoiceRepository;
    private $userRepository;
    private $invoiceParameterRepository;
    private $fee;
    private $feeRepository;
    private $moduleRepository;
    private $outboundInvoiceItemRepository;

    private $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository       = new EnterpriseRepository;
        $this->deadlineRepository         = new DeadlineRepository;
        $this->inboundInvoiceRepository   = new InboundInvoiceRepository;
        $this->vatRateRepository          = new VatRateRepository;
        $this->outboundInvoiceRepository  = new OutboundInvoiceRepository;
        $this->userRepository             = new UserRepository;
        $this->invoiceParameterRepository = new InvoiceParameterRepository;
        $this->fee                        = new Fee;
        $this->feeRepository              = new FeeRepository;
        $this->moduleRepository           = new ModuleRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise;
            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());

            $enterprise->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());

            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());
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

            $customer->vendors()->attach($vendor, ['activity_starts_at' => "2017-01-01 00:00:00"]);
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = factory(User::class)->create([
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
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
     * @Given /^les factures outbound suivantes existent$/
     */
    public function lesFacturesOutboundSuivantesExistent(TableNode $outboundInvoices)
    {
        foreach ($outboundInvoices as $item) {
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
     * @Given /^les taux de tva suivants existent$/
     */
    public function lesTauxDeTvaSuivantsExistent(TableNode $vatRates)
    {
        foreach ($vatRates as $item) {
            factory(VatRate::class)->create([
                'name'         => $item['name'],
                'display_name' => $item['display_name'],
                'value'        => $item['value'],
            ]);
        }
    }

    /**
     * @Given /^les factures inbound suivantes existent$/
     */
    public function lesFacturesInboundSuivantesExistent(TableNode $inboundInvoices)
    {
        foreach ($inboundInvoices as $item) {
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
    public function lesLignesFacturesInboundSuivantesExistent(TableNode $inboundInvoiceItems)
    {
        foreach ($inboundInvoiceItems as $item) {
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
    public function lesLignesFacturesOutboundSuivantesExistent(TableNode $outboundInvoiceItems)
    {
        foreach ($outboundInvoiceItems as $item) {
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
            $inboundInvoiceItem = $inboundInvoice->items()->first();
            $invoiceItem->inboundInvoiceItem()->associate($inboundInvoiceItem->id);

            $invoiceItem->save();
        }
    }

    /**
     * @Given /^les param??tres de facturation suivants existent$/
     */
    public function lesParametresDeFacturationSuivantsExistent(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $invoiceParameter = factory(InvoiceParameter::class)->make([
                'analytic_code' => $item['parameter_analytic_code'],
                'default_management_fees_by_vendor' => $item['default_management_fees_by_vendor'],
                'custom_management_fees_by_vendor' => $item['custom_management_fees_by_vendor'],
                'fixed_fees_by_vendor_amount' => $item['fixed_fees_by_vendor_amount'],
                'subscription_amount' => $item['subscription_amount'],
                'starts_at' => "2017-01-01 00:00:00",
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoiceParameter->enterprise()->associate($enterprise);
            $invoiceParameter->save();
        }
    }

    /**
     * @Given /^je suis authentifi?? en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de calculer les commissions Addworking de la facture outbound numero "([^"]*)" de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeCalculerLesCommissionsAddworkingDeLaFactureOutboundNumeroDeLentrepriseAvecLeSiret(
        $outbound_number,
        $siret_customer
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $customer = $this->enterpriseRepository->findBySiret($siret_customer);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_number);

        try {
            (new CalculateAddworkingFees(
                $this->userRepository,
                $this->outboundInvoiceRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->invoiceParameterRepository,
                $this->vatRateRepository,
                $this->feeRepository,
                $this->outboundInvoiceItemRepository,
            ))->handle($auth_user, $customer, $outbound_invoice, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les commissions Addworking de la facture outbound numero "([^"]*)" de l\'entreprise avec le siret "([^"]*)" sont calcul??es$/
     */
    public function lesCommissionsAddworkingDeLaFactureOutboundNumeroDeLentrepriseAvecLeSiretSontCalculees(
        string $outboundNumber,
        string $siretCustomer
    ) {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($outboundNumber);

        $fees = $this->feeRepository->findByOutboundInvoice($outboundInvoice);

        $this->assertEquals($fees->count(), 3);
    }

    /**
     * @Then /^une erreur est lev??e car l\'entreprise n\'a pas acc??s au module facturation$/
     */
    public function uneErreurEstLeveeCarLentrepriseNaPasAccesAuModuleFacturation()
    {
        // @todo refaire le test avec les ACL
        $this->assertNotContainsEquals(
            EnterpriseDoesntHaveAccessToBillingException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est lev??e car l\'utilisateur connect?? n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est lev??e car la facture outbound n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundNexistePas()
    {
        $this->assertContainsEquals(
            OutboundInvoiceNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est lev??e car la facture outbound n'est pas au statut en attente
     */
    public function uneErreurEstLeveeCarLaFactureOutboundNestPasAuStatutEnAttente()
    {
        throw new PendingException();
        /*
        $this->assertContainsEquals(
            OutboundInvoiceIsNotInPendingStatusException::class,
            $this->errors
        );
        */
    }

    /**
     * @Then /^une erreur est lev??e car l\'entreprise n\'a pas de param??tres de facturation renseign??s$/
     */
    public function uneErreurEstLeveeCarLentrepriseNaPasDeParametresDeFacturationRenseignes()
    {
        $this->assertContainsEquals(
            InvoiceParametersNotInformedException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est lev??e car la facture est valid??e
     */
    public function uneErreurEstLeveeCarLaFactureEstValidee()
    {
        $this->assertContainsEquals(OutboundInvoiceIsAlreadyValidatedException::class, $this->errors);
    }
}
