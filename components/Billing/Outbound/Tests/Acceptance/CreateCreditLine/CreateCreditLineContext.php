<?php

namespace Components\Billing\Outbound\Tests\Acceptance\CreateCreditLine;

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
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceItemNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditLineForOutboundInvoiceItem;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCreditLineContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $inboundInvoiceRepository;
    private $vatRateRepository;
    private $outboundInvoiceRepository;
    private $userRepository;
    private $outboundInvoiceItemRepository;
    private $moduleRepository;
    private $outboundInvoiceItem;
    private $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository          = new EnterpriseRepository;
        $this->deadlineRepository            = new DeadlineRepository;
        $this->inboundInvoiceRepository      = new InboundInvoiceRepository;
        $this->vatRateRepository             = new VatRateRepository;
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository;
        $this->userRepository                = new UserRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
        $this->moduleRepository              = new ModuleRepository;
        $this->outboundInvoiceItem           = new OutboundInvoiceItem;
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
    public function laLigneDeFactureInboundSuivanteExiste(TableNode $inboundInvoiceItems)
    {
        foreach ($inboundInvoiceItems as $item) {
            $inboundInvoiceItem = factory(InboundInvoiceItem::class)->make([
                'label'      => $item['label'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

            $invoice = $this->inboundInvoiceRepository->findBy($item['siret'], $item['number'], $item['month']);
            $inboundInvoiceItem->inboundInvoice()->associate($invoice);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $inboundInvoiceItem->vatRate()->associate($vatRate);

            $inboundInvoiceItem->save();
        }
    }

    /**
     * @Given /^la ligne de facture outbound suivante existe$/
     */
    public function laLigneDeFactureOutboundSuivanteExiste(TableNode $outboundInvoiceItems)
    {
        foreach ($outboundInvoiceItems as $item) {
            $outboundInvoiceItem = factory(OutboundInvoiceItem::class)->make([
                'label'      => $item['label'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'number'     => $item['number']
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $outboundInvoiceItem->outboundInvoice()->associate($outboundInvoice);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $outboundInvoiceItem->vatRate()->associate($vatRate);

            $inboundInvoice = $this->inboundInvoiceRepository
                ->findBy($item['siret_vendor'], $item['inbound_number'], $item['month']);
            $inboundInvoiceItem = $inboundInvoice->items()->first();
            $outboundInvoiceItem->inboundInvoiceItem()->associate($inboundInvoiceItem->id);

            $outboundInvoiceItem->save();
        }
    }

    /**
     * @Given /^la ligne ad-hoc de facture outbound suivante existe$/
     */
    public function laLigneAdHocDeFactureOutboundSuivanteExiste(TableNode $outboundInvoiceItems)
    {
        foreach ($outboundInvoiceItems as $item) {
            $outboundInvoiceItem = factory(OutboundInvoiceItem::class)->make([
                'label'      => $item['label'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'number'     => $item['number']
            ]);

            $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_number']);
            $outboundInvoiceItem->outboundInvoice()->associate($outboundInvoice);

            $vatRate = $this->vatRateRepository->findByValue($item['vat_rate']);
            $outboundInvoiceItem->vatRate()->associate($vatRate);

            $outboundInvoiceItem->save();
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
     * @When /^j\'essaie de créer la ligne d\'avoir de la ligne outbound numéro "([^"]*)" pour la facture outbound "([^"]*)"$/
     */
    public function jessaieDeCreerLaLigneDavoirDeLaLigneOutboundNumeroPourLaFactureOutbound(
        string $outbound_invoice_item_number,
        string $outbound_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $old_outbound_item = $this->outboundInvoiceItemRepository->findByNumber($outbound_invoice_item_number);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_number);

        try {
            (new CreateCreditLineForOutboundInvoiceItem(
                $this->userRepository,
                $this->outboundInvoiceItemRepository,
                $this->outboundInvoiceRepository,
                $this->enterpriseRepository,
                $this->moduleRepository
            ))->handle($auth_user, $outbound_invoice, $old_outbound_item);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la ligne d\'avoir pour la ligne outbound numéro "([^"]*)" est créée$/
     */
    public function laLigneDavoirPourLaLigneOutboundNumeroEstCreee(string $outboundInvoiceItemNumber)
    {
        $outboundInvoiceItem = $this->outboundInvoiceItemRepository->findByNumber(
            $outboundInvoiceItemNumber
        );

        $this->assertEquals(
            1,
            $this->outboundInvoiceItemRepository->findByParentId($outboundInvoiceItem->getId())->count()
        );
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
     * @Then /^une erreur est levée car l\'entreprise n\'a pas acces au module facturation$/
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
     * @Then /^une erreur est levée car la ligne outbound n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaLigneOutboundNexistePas()
    {
        $this->assertContainsEquals(
            OutboundInvoiceItemNotExistsException::class,
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
}
