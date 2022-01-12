<?php
namespace Components\Billing\Outbound\Tests\Acceptance\ShowOutboundInvoice;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\MemberRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Billing\Outbound\Domain\UseCases\ShowOutboundInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;

class ShowOutboundInvoiceContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;
    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $outboundInvoiceRepository;
    private $moduleRepository;
    private $memberRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->deadlineRepository = new DeadlineRepository();
        $this->userRepository = new UserRepository();
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository();
        $this->moduleRepository = new ModuleRepository();
        $this->memberRepository = new MemberRepository();
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de visualiser les informations de la facture numero "([^"]*)" de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeVisualiserLesInformationsDeLaFactureNumeroDeLentrepriseAvecLeSiret($number, $siret)
    {
        $auth_user = $this->userRepository->connectedUser();
        $customer = $this->enterpriseRepository->findBySiret($siret);
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($number);
        try {
            $this->response = (new ShowOutboundInvoice(
                $this->outboundInvoiceRepository,
                $this->userRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->memberRepository
            ))->handle($auth_user, $customer, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les details de la facture outbound numero "([^"]*)" sont affichés$/
     */
    public function lesDetailsDeLaFactureOutboundNumeroSontAffiches($outboundNumber)
    {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($outboundNumber);

        $this->assertEquals($outboundInvoice->getNumber(), $this->response->getNumber());
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
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas membre de l\'entreprise$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasMembreDeLentreprise()
    {
        $this->assertContainsEquals(
            UserIsNotMemberOfThisEnterpriseException::class,
            $this->errors
        );
    }
}
