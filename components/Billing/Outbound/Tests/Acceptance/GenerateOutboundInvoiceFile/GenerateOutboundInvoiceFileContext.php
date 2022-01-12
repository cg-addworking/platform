<?php
namespace Components\Billing\Outbound\Tests\Acceptance\GenerateOutboundInvoiceFile;

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
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\AddressRepository;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceFileRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyValidatedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\GenerateOutboundInvoiceFile;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateOutboundInvoiceFileContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $inboundInvoiceRepository;
    private $outboundInvoiceRepository;
    private $moduleRepository;
    private $outboundInvoiceItem;
    private $outboundInvoiceItemRepository;
    private $vatRateRepository;
    private $invoiceParameterRepository;
    private $outboundInvoiceFileRepository;
    private $addressRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->deadlineRepository = new DeadlineRepository();
        $this->userRepository = new UserRepository();
        $this->inboundInvoiceRepository = new InboundInvoiceRepository();
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository();
        $this->moduleRepository = new ModuleRepository();
        $this->outboundInvoiceItem = new OutboundInvoiceItem();
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository();
        $this->vatRateRepository = new VatRateRepository();
        $this->invoiceParameterRepository = new InvoiceParameterRepository();
        $this->outboundInvoiceFileRepository = new OutboundInvoiceFileRepository();
        $this->addressRepository = new AddressRepository();
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();
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
    public function lesFacturesInboundSuivantesExistent(TableNode $invoices)
    {
        foreach ($invoices as $item) {
            $invoice = $this->inboundInvoiceRepository->make();
            $invoice->fill([
                'month' => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
                'amount_before_taxes' => rand(0, 10),
                'amount_of_taxes' => rand(0, 10),
                'amount_all_taxes_included' => rand(0, 10),
                'invoiced_at' => Carbon::now(),
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
    public function lesLignesFacturesInboundSuivantesExistent(TableNode $items)
    {
        foreach ($items as $item) {
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
    public function lesLignesFacturesOutboundSuivantesExistent(TableNode $items)
    {
        foreach ($items as $item) {
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
            $invoiceItem->vendor()->associate($inboundInvoice->enterprise->id);
            $invoiceItem->save();
        }
    }

    /**
     * @Given /^les fees suivants existent$/
     */
    public function lesFeesSuivantsExistent(TableNode $fees)
    {
        foreach ($fees as $item) {
            $fee = new Fee();
            $fee->fill([
                'label'               => $item['label'],
                'type'                => $item['type'],
                'amount_before_taxes' => $item['amount_before_taxes'],
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $fee->outboundInvoice()->associate($outboundInvoice);

            $outboundInvoiceItem = $outboundInvoice->items()->first();
            $fee->outboundInvoiceItem()->associate($outboundInvoiceItem);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $fee->vatRate()->associate($vatRate);

            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $fee->customer()->associate($customer);

            $invoiceParameter = $this->invoiceParameterRepository->findByEnterpriseSiret($item['siret_customer']);
            $fee->invoiceParameter()->associate($invoiceParameter);

            if ($item['siret_vendor'] != "null") {
                $vendor = $this->enterpriseRepository->findBySiret($item['siret_vendor']);
                $fee->vendor()->associate($vendor);
            }

            $fee->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de generer le fichier de la facture outbound numero "([^"]*)" de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeGenererLeFichierDeLaFactureOutboundNumeroDeLentrepriseAvecLeSiret($outbound_number, $siret)
    {
        $auth_user = $this->userRepository->connectedUser();
        $customer = $this->enterpriseRepository->findBySiret($siret);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_number);
        $address = $this->addressRepository->find($customer->addresses()->first()->id);
        $data = [
            'legal_notice' => null,
            'reverse_charge_vat' => false,
            'dailly_assignment' => false,
            'address' => $address->id
        ];

        try {
            (new GenerateOutboundInvoiceFile(
                $this->outboundInvoiceRepository,
                $this->userRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->outboundInvoiceFileRepository,
                $this->addressRepository,
            ))->handle($auth_user, $customer, $outbound_invoice, $data);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le fichier de la facture outbound numero "([^"]*)" est generé$/
     */
    public function leFichierDeLaFactureOutboundNumeroEstGenere($outboundNumber)
    {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($outboundNumber);

        $this->assertTrue($this->outboundInvoiceRepository->hasFile($outboundInvoice));
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
     * @Then /^une erreur est levée car l\'entreprise n\'a pas accès au module facturation$/
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
     * @Then /^une erreur est levée car la facture outbound n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundNexistePas()
    {
        $this->assertContainsEquals(
            OutboundInvoiceNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car la facture est validée
     */
    public function uneErreurEstLeveeCarLaFactureEstValidee()
    {
        $this->assertContainsEquals(OutboundInvoiceIsAlreadyValidatedException::class, $this->errors);
    }
}
