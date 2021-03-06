<?php

namespace Components\Billing\PaymentOrder\Tests\Acceptance\CreateReceivedPayment;

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
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ModuleRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentOutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\CreateReceivedPayment;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateReceivedPaymentContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $outboundInvoiceRepository;
    private $ibanRepository;
    private $receivedPaymentRepository;
    private $moduleRepository;
    private $receivedPaymentOutboundInvoiceRepository;

    private $errors = [];
    private $response;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository      = new EnterpriseRepository;
        $this->deadlineRepository        = new DeadlineRepository;
        $this->userRepository            = new UserRepository;
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository;
        $this->ibanRepository            = new IbanRepository;
        $this->receivedPaymentRepository = new ReceivedPaymentRepository;
        $this->moduleRepository          = new ModuleRepository;
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
    public function laFactureOutboundSuivanteExiste(TableNode $outboundInvoices)
    {
        foreach ($outboundInvoices as $item) {
            $invoice = factory(OutboundInvoice::class)->make([
                'month'  => $item['month'],
                'status' => $item['status'],
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoice->enterprise()->associate($enterprise->id);

            $deadline = $this->deadlineRepository->findByName($item['deadline_name']);
            $invoice->deadline()->associate($deadline);

            $invoice->save();
        }
    }

    /**
     * @Given /^je suis authentifi?? en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de cr??er une notification de fonds re??us pour l\'entreprise avec siret "([^"]*)" avec la facture outbound numero "([^"]*)"$/
     */
    public function jessaieDeCreerUneNotificationDeFondsRecusPourLentrepriseAvecSiretAvecLaFactureOutboundNumero(
        $siret,
        $outbound_invoice_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_invoice_number);
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $addworking = $this->enterpriseRepository->findBySiret('01000000000000');
        $iban = $this->ibanRepository->findByEnterprise($addworking);

        $data = [
            'iban' => $iban->id,
            'bank_reference_payment' => "AZERTYUIOP1234567890QSDFGHJKLM",
            'amount' => 12345.67,
            'received_at' => '2020-05-31',
            'outbound_invoice' => [
                $outbound_invoice->getId(),
            ],
        ];

        try {
            $this->response = (new CreateReceivedPayment(
                $this->userRepository,
                $this->ibanRepository,
                $this->receivedPaymentRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->outboundInvoiceRepository,
                $this->receivedPaymentOutboundInvoiceRepository
            ))->handle($auth_user, $enterprise, $data);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la notification de fonds re??us est cr????e$/
     */
    public function laNotificationDeFondsRecusEstCreee()
    {
        $this->assertDatabaseHas('addworking_billing_received_payments', [
            'iban_id'                => $this->response->getIban()->id,
            'bank_reference_payment' => $this->response->getBankReferencePayment(),
            'amount'                 => $this->response->getAmount()
        ]);
    }

    /**
     * @Then /^une erreur est lev??e car l\'utilisateur connect?? n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }
}
