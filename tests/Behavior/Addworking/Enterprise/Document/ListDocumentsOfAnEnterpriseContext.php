<?php

namespace Tests\Behavior\Addworking\Enterprise\Document;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Enterprise\DocumentPolicy;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\User\User\Application\Repositories\UserRepository;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class ListDocumentsOfAnEnterpriseContext extends TestCase implements Context
{
    use RefreshDatabase, HasGivenAndThenStep;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $authentificated;
    protected $documentOwner;
    protected $policy;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
        $this->authentificated = $user;
    }

    /**
     * @Given mon onboarding est à l'étape des téléchargements des documents
     */
    public function monOnboardingEstALetapeDesTelechargementsDesDocuments()
    {
        $onboarding = $this->authentificated->onboardingProcesses()->first();

        $onboarding->update(['current_step' => 5]);
    }

    /**
     * @Given mon onboarding est complet
     */
    public function monOnboardingEstComplet()
    {
        $onboarding = $this->authentificated->onboardingProcesses()->first();

        $onboarding->update(
            ['complete' => true,
            'completed_at' => "2017-01-01 00:00:00"]
        );
    }

    /**
     * @Given mon onboarding est à l'étape de confirmation d'email
     */
    public function monOnboardingEstALetapeDeConfirmationDemail()
    {
        $onboarding = $this->authentificated->onboardingProcesses()->first();

        $onboarding->update(['current_step' => 1]);
    }

    /**
     * @When /^j\'essaie d\'accéder à l\'index des documents de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDaccederALindexDesDocumentsDeLentrepriseAvecLeSiret($siret)
    {
        $this->documentOwner = $this->enterpriseRepository->findBySiret($siret);

        $this->policy = $this->app->make(DocumentPolicy::class);
    }

    /**
     * @Then /^l\'accès est permis$/
     */
    public function laccesEstPermis()
    {
        $this->assertTrue($this->policy->index($this->authentificated, $this->documentOwner));
    }

    /**
     * @Then /^l\'accès est refusé$/
     */
    public function laccesEstRefuse()
    {
        $this->assertFalse($this->policy->index($this->authentificated, $this->documentOwner));
    }
}
