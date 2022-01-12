<?php

namespace Components\Billing\Outbound\Tests\Acceptance\DeleteCreditAddworkingFeesFromCreditNote;

use App\Models\Addworking\Billing\DeadlineType;
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
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Exceptions\FeeNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyPaidException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\DeleteCreditAddworkingFeeFromCreditNote;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCreditAddworkingFeesFromCreditNoteContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $outboundInvoiceRepository;
    private $vatRateRepository;
    private $invoiceParameterRepository;
    private $feeRepository;
    private $userRepository;
    private $moduleRepository;

    private $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository       = new EnterpriseRepository;
        $this->deadlineRepository         = new DeadlineRepository;
        $this->outboundInvoiceRepository  = new OutboundInvoiceRepository;
        $this->vatRateRepository          = new VatRateRepository;
        $this->invoiceParameterRepository = new InvoiceParameterRepository;
        $this->feeRepository              = new FeeRepository;
        $this->userRepository             = new UserRepository;
        $this->moduleRepository           = new ModuleRepository;
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
    public function lesFacturesOutboundSuivantesExistent(TableNode $invoices)
    {
        foreach ($invoices as $item) {
            $invoice = factory(OutboundInvoice::class)->make([
                'month'  => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            if ($item['parent_number'] != null) {
                $outboundParent = $this->outboundInvoiceRepository->findByNumber($item['parent_number']);
                $invoice->parent()->associate($outboundParent);
            }

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
     * @Given /^les parameters de facturation suivants existent$/
     */
    public function lesParametersDeFacturationSuivantsExistent(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $parameter = factory(InvoiceParameter::class)->make([
                'starts_at' => "2019-01-01 00:00:00",
                'number' => $item['number'],
            ]);
            $parameter->enterprise()->associate($enterprise);

            $parameter->save();
        }
    }

    /**
     * @Given /^les commissions de facture outbound suivantes existent$/
     */
    public function lesCommissionsDeFactureOutboundSuivantesExistent(TableNode $fees)
    {
        foreach ($fees as $item) {
            $fee = new Fee;
            $fee->fill([
                'label'               => $item['label'],
                'type'                => $item['type'],
                'amount_before_taxes' => $item['amount_before_taxes'],
                'number'              => $item['number']
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $fee->outboundInvoice()->associate($outboundInvoice);

            if ($item['parent_number'] != null) {
                $feeParent = $this->feeRepository->findByNumber($item['parent_number']);
                $fee->parent()->associate($feeParent);
            }

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $fee->vatRate()->associate($vatRate);

            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $fee->customer()->associate($customer);

            $invoiceParameter = $this->invoiceParameterRepository->findByEnterpriseSiret($item['siret_customer']);
            $fee->invoiceParameter()->associate($invoiceParameter);

            $fee->save();
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
     * @When /^j\'essaie de supprimer la commission d\'avoir numéro "([^"]*)" de la facture d\'avoir "([^"]*)"$/
     */
    public function jessaieDeSupprimerLaCommissionDavoirNumeroDeLaFactureDavoir(
        string $feeNumber,
        string $invoiceNumber
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $fee = $this->feeRepository->findByNumber($feeNumber);
        $invoice = $this->outboundInvoiceRepository->findByNumber($invoiceNumber);

        try {
            (new DeleteCreditAddworkingFeeFromCreditNote(
                $this->userRepository,
                $this->enterpriseRepository,
                $this->outboundInvoiceRepository,
                $this->feeRepository,
                $this->moduleRepository
            ))->handle($auth_user, $fee, $invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la commission d\'avoir numéro "([^"]*)" est supprimée de la facture d\'avoir$/
     */
    public function laCommissionDavoirEstSupprimeeDeLaFactureDavoir(string $feeNumber)
    {
        $this->assertEquals(1, Fee::where('number', $feeNumber)->withTrashed()->count());
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car la facture d\'avoir n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaFactureDavoirNexistePas()
    {
        $this->assertContainsEquals(
            OutboundInvoiceNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car la facture d\'avoir est au statut payée$/
     */
    public function uneErreurEstLeveeCarLaFactureDavoirEstAuStatutPayee()
    {
        $this->assertContainsEquals(
            OutboundInvoiceIsAlreadyPaidException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car la commission d\'avoir n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaCommissionDavoirNexistePas()
    {
        $this->assertContainsEquals(
            FeeNotExistsException::class,
            $this->errors
        );
    }
}
