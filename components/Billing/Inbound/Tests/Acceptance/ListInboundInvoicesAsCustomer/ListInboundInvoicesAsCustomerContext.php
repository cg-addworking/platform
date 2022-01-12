<?php

namespace Components\Billing\Inbound\Tests\Acceptance\ListInboundInvoicesAsCustomer;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Exception\Exception;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Inbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Inbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Inbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Inbound\Application\Repositories\UserRepository;
use Components\Billing\Inbound\Domain\UseCases\ListInboundInvoicesAsCustomer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListInboundInvoicesAsCustomerContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $inboundInvoiceRepository;

    private $response;
    private $errors;
    
    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository     = new EnterpriseRepository;
        $this->deadlineRepository       = new DeadlineRepository;
        $this->userRepository           = new UserRepository;
        $this->inboundInvoiceRepository = new InboundInvoiceRepository;
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
            if ($user = User::where('email', $item['email'])->first()) {
                $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
                $user->enterprises()->attach($enterprise);
            } else {
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
    }

    /**
     * @Given /^les partenariats suivants existent$/
     */
    public function lesPartenariatsSuivantsExistent(TableNode $partnerships)
    {
        foreach ($partnerships as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $vendor   = $this->enterpriseRepository->findBySiret($item['siret_vendor']);

            $customer->vendors()->attach($vendor, ['activity_starts_at' => $item['activity_starts_at']]);
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
     * @Given /^les factures inbound suivantes existent$/
     */
    public function lesFacturesInboundSuivantesExistent(TableNode $invoices)
    {
        foreach ($invoices as $item) {
            $invoice = factory(InboundInvoice::class)->make([
                'month' => $item['month'],
            ]);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $customer = $this->enterpriseRepository->findBySiret($item['customer_siret']);
            $invoice->customer()->associate($customer->id);

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
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister les factures inbound de mes prestataires$/
     */
    public function jessaieDeListerLesFacturesInboundDeMesPrestataires()
    {
        $auth_user = $this->userRepository->connectedUser();
        $filter = null;
        $search = null;

        try {
            $this->response = (new ListInboundInvoicesAsCustomer(
                $this->inboundInvoiceRepository
            ))->handle($auth_user, $filter, $search);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les factures inbound de mes prestataires sont listées$/
     */
    public function lesFacturesInboundDeMesPrestatairesSontListees()
    {
        $this->assertDatabaseCount('addworking_billing_inbound_invoices', 5);
        $this->assertCount(3, $this->response);
    }
}
