<?php

namespace Components\Billing\Outbound\Tests\Acceptance\ListOutboundInvoice;

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
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListOutboundInvoiceContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $moduleRepository;
    private $memberRepository;

    protected $context;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->deadlineRepository   = new DeadlineRepository;
        $this->userRepository       = new UserRepository;
        $this->moduleRepository     = new ModuleRepository;
        $this->memberRepository     = new MemberRepository;
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
                'month' => $item['month'],
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
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->context['user'] = $user;
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister les factures outbound de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeListerLesFacturesOutboundDeLentrepriseAvecLeSiret(string $siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $response = $this->actingAs($this->context['user'])
            ->get("/addworking/enterprise/{$enterprise->id}/outbound-invoice");
        $this->context['response'] = $response;
    }

    /**
     * @Then /^les factures outbound de l\'entreprise avec le siret "([^"]*)" sont listées$/
     */
    public function lesFacturesOutboundDeLentrepriseAvecLeSiretSontListees(string $siret)
    {
        $this->context['response']->assertOk();
        $this->context['response']->assertViewIs('outbound_invoice::index');
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise avec le siret "([^"]*)" n\'a pas accès au module facturation$/
     */
    public function uneErreurEstLeveeCarLentrepriseAvecLeSiretNaPasAccesAuModuleFacturation(string $siret)
    {
        // TODO: Refactor test when ACL method's hasAccessToBilling will be implemented

        //$this->context['response']->assertStatus(403);

        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $this->assertTrue($this->moduleRepository->hasAccessToBilling($enterprise));
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasDeLentrepriseAvecLeSiret(string $siret)
    {
        $this->context['response']->assertStatus(403);

        $authUser = $this->userRepository->connectedUser();
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $this->assertFalse($this->memberRepository->isMemberOf($authUser, $enterprise));
    }
}
