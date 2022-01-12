<?php

namespace Components\Billing\PaymentOrder\Tests\Acceptance\ListReceivedPayment;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ModuleRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPayment;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListReceivedPaymentContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $ibanRepository;
    private $outboundInvoiceRepository;
    private $userRepository;
    private $receivedPaymentRepository;
    private $moduleRepository;

    private $errors = [];
    private $items;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository      = new EnterpriseRepository;
        $this->deadlineRepository        = new DeadlineRepository;
        $this->ibanRepository            = new IbanRepository;
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository;
        $this->userRepository            = new UserRepository;
        $this->receivedPaymentRepository = new ReceivedPaymentRepository;
        $this->moduleRepository          = new ModuleRepository;
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
     * @Given /^les ibans suivants existent$/
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = factory(Iban::class)->make(['status' => "approved"]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $iban->enterprise()->associate($enterprise);
            $iban->save();
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
     * @Given /^les factures addworking suivantes existent$/
     */
    public function lesFacturesAddworkingSuivantesExistent(TableNode $outbound_invoices)
    {
        foreach ($outbound_invoices as $item) {
            $invoice = factory(OutboundInvoice::class)->make([
                'month'  => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $invoice->enterprise()->associate($enterprise->id);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $invoice->save();
        }
    }

    /**
     * @Given /^les notifications de fonds reçus suivantes existent$/
     */
    public function lesNotificationsDeFondsRecusSuivantesExistent(TableNode $received_payments)
    {
        foreach ($received_payments as $item) {
            $payment = factory(ReceivedPayment::class)->make([
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister les notifications de fonds reçus pour l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeListerLesNotificationsDeFondsRecusPourLentrepriseAvecLeSiret($siret)
    {
        $auth_user = $this->userRepository->connectedUser();
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        try {
            $this->items = (new ListReceivedPayment(
                $this->userRepository,
                $this->receivedPaymentRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
            ))->handle($auth_user, $enterprise);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les notifications de fonds reçus sont listées$/
     */
    public function lesNotificationsDeFondsRecusSontListees()
    {
        $this->assertCount(3, $this->items);
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
