<?php

namespace Components\Billing\PaymentOrder\Tests\Acceptance\ShowPaymentOrder;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\ShowPaymentOrder;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowPaymentOrderContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $deadlineRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $paymentOrderRepository;

    private $response;
    private $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->deadlineRepository        = new DeadlineRepository;
        $this->enterpriseRepository      = new EnterpriseRepository;
        $this->userRepository            = new UserRepository;
        $this->paymentOrderRepository    = new PaymentOrderRepository;
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
     * @Given /^l\'ordre de paiement suivant existe$/
     */
    public function lordreDePaiementSuivantExiste(TableNode $payment_orders)
    {
        foreach ($payment_orders as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);

            $payment_order = factory(PaymentOrder::class)->make([
                'number'        => $item['number'],
                'customer_name' => $customer->name
            ]);

            $payment_order->enterprise()->associate($customer);
            $payment_order->save();
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
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de voir le détail de l\'ordre de paiement numéro "([^"]*)"$/
     */
    public function jessaieDeVoirLeDetailDeLordreDePaiementNumero(string $number)
    {
        $payment_order = $this->paymentOrderRepository->findByNumber($number);
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ShowPaymentOrder(
                $this->userRepository,
                $this->paymentOrderRepository
            ))->handle($auth_user, $payment_order);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le détail de l\'ordre de paiement numéro "([^"]*)" est affiché$/
     */
    public function leDetailDeLordreDePaiementNumeroEstAffiche(string $number)
    {
        $payment_order = $this->paymentOrderRepository->findByNumber($number);

        $this->assertEquals($payment_order->getNumber(), $this->response->getNumber());
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
}
