<?php

namespace Components\Billing\Outbound\Tests\Acceptance\AddAdHocLineToOutboundInvoice;

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
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\AddAdHocLineToOutboundInvoice;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddAdHocLineToOutboundInvoiceContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $moduleRepository;
    private $outboundInvoiceRepository;
    private $outboundInvoiceItemRepository;
    private $outboundInvoiceItem;
    private $vatRateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository          = new EnterpriseRepository;
        $this->deadlineRepository            = new DeadlineRepository;
        $this->userRepository                = new UserRepository;
        $this->moduleRepository              = new ModuleRepository;
        $this->outboundInvoiceRepository     = new OutboundInvoiceRepository;
        $this->outboundInvoiceItemRepository = new OutboundInvoiceItemRepository;
        $this->outboundInvoiceItem           = new OutboundInvoiceItem;
        $this->vatRateRepository             = new VatRateRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();
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
    public function lesFacturesOutboundSuivantesExistent(TableNode $invoices)
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }


    /**
     * @When /^j\'essaie d\'ajouter une ligne de facture ad-hoc pour la facture outbound avec le numéro "([^"]*)" de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDajouterUneLigneDeFactureAdHocPourLaFactureOutboundAvecLeNumeroDeLentrepriseAvecLeSiret(
        string $number,
        string $siret
    ) {
        $vat_rate = $this->vatRateRepository->findByValue('20');

        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($number);

        $customer = $this->enterpriseRepository->findBySiret($siret);

        $auth_user = $this->userRepository->connectedUser();

        $data = [
            'label'       => "Ligne de facture X",
            'vat_rate_id' => $vat_rate->id,
            'quantity'    => 42,
            'unit_price'  => 123.45
        ];

        try {
            (new AddAdHocLineToOutboundInvoice(
                $this->userRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->outboundInvoiceRepository,
                $this->outboundInvoiceItemRepository
            ))->handle($auth_user, $customer, $outbound_invoice, $data);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la ligne de facture ad-hoc pour la facture outbound avec le numéro "([^"]*)" est créée$/
     */
    public function laLigneDeFactureAdHocPourLaFactureOutboundAvecLeNumeroEstCreee(string $number)
    {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($number);

        $this->assertEquals(1, $outboundInvoice->items()->count());
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
     * @Then /^une erreur est levée car la facture outbound n\'est pas au statut en attente$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundNestPasAuStatutEnAttente()
    {
        $this->assertContainsEquals(
            OutboundInvoiceIsNotInPendingStatusException::class,
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
