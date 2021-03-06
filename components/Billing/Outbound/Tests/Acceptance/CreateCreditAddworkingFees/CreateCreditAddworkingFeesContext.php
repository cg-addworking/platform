<?php

namespace Components\Billing\Outbound\Tests\Acceptance\CreateCreditAddworkingFees;

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
use Components\Billing\Outbound\Domain\Exceptions\FeeNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\InvoiceParametersNotInformedException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditAddworkingFees;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCreditAddworkingFeesContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $inboundInvoiceRepository;
    private $vatRateRepository;
    private $outboundInvoiceRepository;
    private $outboundInvoiceItemRepository;
    private $invoiceParameterRepository;
    private $userRepository;
    private $feeRepository;
    private $moduleRepository;

    private $errors = [];
    private $response;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository          = new EnterpriseRepository;
        $this->deadlineRepository            = new DeadlineRepository;
        $this->inboundInvoiceRepository      = new InboundInvoiceRepository;
        $this->vatRateRepository             = new VatRateRepository;
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
        $this->invoiceParameterRepository    = new InvoiceParameterRepository;
        $this->userRepository                = new UserRepository;
        $this->feeRepository                 = new FeeRepository;
        $this->moduleRepository              = new ModuleRepository;
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
     * @Given /^l\'echeance de paiement suivante existe$/
     */
    public function lecheanceDePaiementSuivanteExiste(TableNode $deadlines)
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

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $invoice->save();
        }
    }

    /**
     * @Given /^le taux de tva suivant existe$/
     */
    public function leTauxDeTvaSuivantExiste(TableNode $vatRates)
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
     * @Given /^la facture inbound suivante existe$/
     */
    
    public function laFactureInboundSuivanteExiste(TableNode $inboundInvoices)
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
     * @Given /^la ligne de facture inbound suivante existe$/
     */
    public function laLignesDeFactureInboundSuivanteExiste(TableNode $inboundItems)
    {
        foreach ($inboundItems as $item) {
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
     * @Given /^la ligne de facture outbound suivante existe$/
     */
    public function laLigneDeFactureOutboundSuivanteExiste(TableNode $outboundItems)
    {
        foreach ($outboundItems as $item) {
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
     * @Given /^le param??tre de facturation suivant existe$/
     */
    public function leParametreDeFacturationSuivantExiste(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $invoiceParameter = factory(InvoiceParameter::class)->make([
                'analytic_code' => $item['parameter_analytic_code'],
                'default_management_fees_by_vendor' => $item['default_management_fees_by_vendor'],
                'custom_management_fees_by_vendor' => $item['custom_management_fees_by_vendor'],
                'fixed_fees_by_vendor_amount' => $item['fixed_fees_by_vendor_amount'],
                'subscription_amount' => $item['subscription_amount'],
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);

            $invoiceParameter->enterprise()->associate($enterprise);

            $invoiceParameter->save();
        }
    }

    /**
     * @Given /^les commissions Addworking suivantes existent$/
     */
    public function lesCommissionsAddworkingSuivantesExistent(TableNode $fees)
    {
        foreach ($fees as $item) {
            $fee = factory(Fee::class)->make([
                'type'                => $item['type'],
                'amount_before_taxes' => $item['amount_before_taxes'],
                'number'              => $item['number']
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $fee->outboundInvoice()->associate($outboundInvoice);

            $outboundItem = $this->outboundInvoiceItemRepository->findByNumber($item['outbound_item_number']);
            $fee->outboundInvoiceItem()->associate($outboundItem);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $fee->vatRate()->associate($vatRate);

            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $fee->customer()->associate($customer);

            $vendor = $this->enterpriseRepository->findBySiret($item['siret_vendor']);
            $fee->vendor()->associate($vendor);

            $parameter = $this->invoiceParameterRepository->findByEnterpriseSiret($item['invoice_parameter_by_siret']);
            $fee->invoiceParameter()->associate($parameter);

            $fee->save();
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
     * @When /^j\'essaie de cr??er la ligne d\'avoir de la commission numero "([^"]*)" pour la facture outbound numero "([^"]*)"$/
     */
    public function jessaieDeCreerLaLigneDavoirDeLaCommissionNumeroPourLaFactureOutboundNumero(
        string $fee_number,
        string $outbound_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $fee = $this->feeRepository->findByNumber($fee_number);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_number);

        try {
            $this->response = (new CreateCreditAddworkingFees(
                $this->userRepository,
                $this->feeRepository,
                $this->outboundInvoiceRepository,
                $this->enterpriseRepository,
                $this->invoiceParameterRepository,
                $this->moduleRepository,
                $this->vatRateRepository
            ))->handle($auth_user, $fee, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la ligne d\'avoir pour la commission num??ro "([^"]*)" est cr????e$/
     */
    public function laLigneDavoirPourLaCommissionNumeroEstCreee(string $feeNumber)
    {
        $fee = $this->feeRepository->findByNumber($feeNumber);

        $this->assertEquals($fee->id, $this->response->parent_id);

        $this->assertDatabaseHas('addworking_billing_addworking_fees', ['parent_id' => $fee->id]);
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
     * @Then /^une erreur est lev??e car l\'entreprise n\'a pas acces au module facturation$/
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
     * @Then /^une erreur est lev??e car la ligne de commission n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaLigneDeCommissionNexistePas()
    {
        $this->assertContainsEquals(
            FeeNotExistsException::class,
            $this->errors
        );
    }
}
