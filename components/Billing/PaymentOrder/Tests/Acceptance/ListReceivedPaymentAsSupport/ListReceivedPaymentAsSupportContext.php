<?php

namespace Components\Billing\PaymentOrder\Tests\Acceptance\ListReceivedPaymentAsSupport;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ModuleRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentOutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPaymentAsSupport;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListReceivedPaymentAsSupportContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $ibanRepository;
    private $outboundInvoiceRepository;
    private $userRepository;
    private $receivedPaymentRepository;
    private $moduleRepository;
    private $receivedPaymentOutboundInvoiceRepository;

    private $errors = [];
    private $items;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->deadlineRepository = new DeadlineRepository;
        $this->ibanRepository = new IbanRepository;
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository;
        $this->userRepository = new UserRepository;
        $this->receivedPaymentRepository = new ReceivedPaymentRepository;
        $this->moduleRepository = new ModuleRepository;
        $this->receivedPaymentOutboundInvoiceRepository = new ReceivedPaymentOutboundInvoiceRepository;
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
     * @Given /^les paiements reçus suivants existent$/
     */
    public function lesPaiementsRecusSuivantsExistent(TableNode $received_payments)
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

            $payment->refresh();

            $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($item['outbound_invoice_number']);

            $relation = $this->receivedPaymentOutboundInvoiceRepository->make();
            $relation->setOutboundInvoice($outbound_invoice);
            $relation->setReceivedPayment($payment);
            $this->receivedPaymentOutboundInvoiceRepository->save($relation);
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
     * @When /^j\'essaie de lister tous les paiements reçus$/
     */
    public function jessaieDeListerTousLesPaiementsRecus()
    {
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->items = (new ListReceivedPaymentAsSupport(
                $this->userRepository,
                $this->receivedPaymentRepository
            ))->handle($auth_user);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les paiements reçus sont listées$/
     */
    public function lesPaiementsRecusSontListees()
    {
        $this->assertCount(24, $this->items);
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
