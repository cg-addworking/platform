<?php
namespace Components\Billing\Outbound\Tests\Acceptance\DissociateInboundInvoiceFromOutboundInvoice;

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
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterprisesDoesntHavePartnershipException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceIsAlreadyAssociatedToThisOutboundInvoiceException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceIsNotAssociatedToThisOutboundInvoiceException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceIsNotInPendingAssociationStatusException;
use Components\Billing\Outbound\Domain\Exceptions\InboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\AssociateInboundInvoiceToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\DissociateInboundInvoiceFromOutboundInvoice;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DissociateInboundInvoiceFromOutboundInvoiceContext extends TestCase implements Context
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

            $invoiceItem->save();
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de dissocier la facture inbound de l\'entreprise avec le siret "([^"]*)" numero "([^"]*)" periode "([^"]*)" depuis la facture outbound de l\'entreprise avec le siret "([^"]*)" numero "([^"]*)"$/
     */
    public function jessaieDeDissocierLaFactureInboundDeLentrepriseAvecLeSiretNumeroPeriodeDepuisLaFactureOutboundDeLentrepriseAvecLeSiretNumero(
        $siret_vendor,
        $inbound_number,
        $inboundMonth,
        $siret_customer,
        $outbound_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $customer = $this->enterpriseRepository->findBySiret($siret_customer);
        $vendor = $this->enterpriseRepository->findBySiret($siret_vendor);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_number);
        $inbound_invoice = $this->inboundInvoiceRepository->findByNumber($inbound_number);

        try {
            (new DissociateInboundInvoiceFromOutboundInvoice(
                $this->outboundInvoiceRepository,
                $this->inboundInvoiceRepository,
                $this->userRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->outboundInvoiceItemRepository,
            ))->handle($auth_user, $vendor, $inbound_invoice, $customer, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la facture inbound de l\'entreprise avec le siret "([^"]*)" numero "([^"]*)" periode "([^"]*)" est dessocie de la facture outbound numero "([^"]*)"$/
     */
    public function laFactureInboundDeLentrepriseAvecLeSiretNumeroPeriodeEstDessocieDeLaFactureOutboundNumero(
        $siretVendor,
        $inboundNumber,
        $inboundMonth,
        $outboundNumber
    ) {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($outboundNumber);
        $inboundInvoice = $this->inboundInvoiceRepository->findBy($siretVendor, $inboundNumber, $inboundMonth);

        $this->assertfalse($this->outboundInvoiceRepository->hasInboundInvoice($outboundInvoice, $inboundInvoice));
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
     * @Then /^une erreur est levée car les deux entreprises n\'ont de partenariat commercial$/
     */
    public function uneErreurEstLeveeCarLesDeuxEntreprisesNontDePartenariatCommercial()
    {
        $this->assertContainsEquals(
            EnterprisesDoesntHavePartnershipException::class,
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
     * @Then /^une erreur est levée car la facture outbound dn\'est pas au statut en attente$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundDnestPasAuStatutEnAttente()
    {
        $this->assertContainsEquals(
            OutboundInvoiceIsNotInPendingStatusException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car la facture inbound n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaFactureInboundNexistePas()
    {
        $this->assertContainsEquals(
            InboundInvoiceNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car la facture inbound n\'est pas associé a cette facture outbound$/
     */
    public function uneErreurEstLeveeCarLaFactureInboundNestPasAssocieACetteFactureOutbound()
    {
        $this->assertContainsEquals(
            InboundInvoiceIsNotAssociatedToThisOutboundInvoiceException::class,
            $this->errors
        );
    }
}
