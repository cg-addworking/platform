<?php
namespace Components\Billing\PaymentOrder\Tests\Acceptance\DeleteReceivedPayment;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\ReceivedPaymentNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\DeleteReceivedPayment;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteReceivedPaymentContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private EnterpriseRepository $enterpriseRepository;
    private IbanRepository $ibanRepository;
    private ReceivedPaymentRepository $receivedPaymentRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->ibanRepository = new IbanRepository();
        $this->userRepository = new UserRepository();
        $this->receivedPaymentRepository = new ReceivedPaymentRepository();
    }

    /**
     * @Given les entreprises suivantes existent
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
            ])->save();
        }
    }

    /**
     * @Given les utilisateurs suivants existent
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = new User();
            $user->fill([
                'gender'          => array_random(['male', 'female']),
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
                'password'        => Hash::make('password'),
                'is_system_admin' => $item['is_system_admin'],
            ])->save();

            $user->enterprises()->attach($this->enterpriseRepository->findBySiret($item['siret']));
        }
    }

    /**
     * @Given les ibans suivants existent
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = factory(Iban::class)->make(['status' => $item['status']]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $iban->enterprise()->associate($enterprise);
            $iban->save();
        }
    }

    /**
     * @Given les paiements reçus suivants existent
     */
    public function lesPaiementsRecusSuivantsExistent(TableNode $received_payments)
    {
        foreach ($received_payments as $item) {
            $payment = new ReceivedPayment();

            $payment->fill([
                'number' => $item['number']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $payment->enterprise()->associate($enterprise);

            $addworking = $this->enterpriseRepository->findBySiret($item['siret_addworking_for_iban']);
            $iban = $this->ibanRepository->findByEnterprise($addworking);
            $payment->iban()->associate($iban);

            $payment->save();
        }
    }

    /**
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de supprimer le paiement reçu numéro :arg1
     */
    public function jessaieDeSupprimerLePaiementRecuNumero(string $number)
    {
        $user = $this->userRepository->connectedUser();
        $received_payment = $this->receivedPaymentRepository->findByNumber($number);

        try {
            $this->response = (new DeleteReceivedPayment(
                $this->userRepository,
                $this->receivedPaymentRepository
            ))->handle($user, $received_payment);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le paiement reçu numéro :arg1 est supprimé
     */
    public function lePaiementRecuNumeroEstModifie(string $number)
    {
        $received_payment = $this->receivedPaymentRepository->findTrashedByNumber($number);
        $this->assertNotNull($received_payment);
        $this->assertTrue($this->response);
        $this->assertNotNull($received_payment->getDeletedAt());
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas support
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car le paiement reçu n'existe pas
     */
    public function uneErreurEstLeveeCarLePaiementRecuNexistePas()
    {
        $this->assertContainsEquals(
            ReceivedPaymentNotExistsException::class,
            $this->errors
        );
    }

}
