<?php

namespace Components\Billing\Outbound\Tests\Acceptance\DeleteAdHocLineFromOutboundInvoice;

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
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyPaidException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceItemNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\DeleteAdHocLineFromOutboundInvoice;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAdHocLineFromOutboundInvoiceContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];

    protected $deadlineRepository;
    protected $enterpriseRepository;
    protected $moduleRepository;
    protected $outboundInvoiceItemRepository;
    protected $outboundInvoiceRepository;
    protected $userRepository;
    protected $vatRateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository          = new EnterpriseRepository;
        $this->deadlineRepository            = new DeadlineRepository;
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository;
        $this->vatRateRepository             = new VatRateRepository;
        $this->userRepository                = new UserRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
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
     * @Given /^la facture outbound suivante existe$/
     */
    public function laFactureOutboundSuivanteExiste(TableNode $invoices)
    {
        foreach ($invoices as $item) {
            $invoice = factory(OutboundInvoice::class)->make([
                'month'  => $item['month'],
                'number' => $item['number'],
                'status' => $item['status']
            ]);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

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
     * @Given /^la ligne ad-hoc de facture outbound suivante existe$/
     */
    public function laLigneAdHocDeFactureOutboundSuivanteExiste(TableNode $invoiceItems)
    {
        foreach ($invoiceItems as $item) {
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
     * @When /^j\'essaie de supprimer la ligne ad-hoc numéro "([^"]*)" de la facture outbound "([^"]*)"$/
     */
    public function jessaieDeSupprimerLaLigneAdHocNumeroDeLaFactureOutbound(string $item_number, string $invoice_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($invoice_number);
        $outbound_invoice_item = $this->outboundInvoiceItemRepository->findByNumber($item_number);

        try {
            (new DeleteAdHocLineFromOutboundInvoice(
                $this->userRepository,
                $this->outboundInvoiceRepository,
                $this->outboundInvoiceItemRepository,
                $this->enterpriseRepository,
                $this->moduleRepository
            ))->handle($auth_user, $outbound_invoice, $outbound_invoice_item);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la ligne ad-hoc est supprimée de la facture outbound "([^"]*)"$/
     */
    public function laLigneAdHocEstSupprimeeDeLaFactureOutbound(string $invoiceNumber)
    {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber(
            $invoiceNumber
        );

        $this->assertEquals(
            0,
            $outboundInvoice->items()->count()
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
     * @Then /^une erreur est levée car la facture outbound est au statut payée$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundEstAuStatutPayee()
    {
        $this->assertContainsEquals(
            OutboundInvoiceIsAlreadyPaidException::class,
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
}
