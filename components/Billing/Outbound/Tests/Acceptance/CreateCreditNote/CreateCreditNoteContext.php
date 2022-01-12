<?php

namespace Components\Billing\Outbound\Tests\Acceptance\CreateCreditNote;

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
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditNoteForOutboundInvoice;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCreditNoteContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $outboundInvoiceRepository;
    private $moduleRepository;
    private $outboundInvoice;
    private $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository      = new EnterpriseRepository;
        $this->deadlineRepository        = new DeadlineRepository;
        $this->userRepository            = new UserRepository;
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository;
        $this->moduleRepository          = new ModuleRepository;
        $this->outboundInvoice           = new OutboundInvoice;
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de créer une facture d\'avoir pour la facture outbound numero "([^"]*)"$/
     */
    public function jessaieDeCreerUneFactureDavoirPourLaFactureOutboundNumero(string $outbound_invoice_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($outbound_invoice_number);

        try {
            (new CreateCreditNoteForOutboundInvoice(
                $this->userRepository,
                $this->outboundInvoiceRepository,
                $this->enterpriseRepository,
                $this->moduleRepository,
                $this->deadlineRepository
            ))->handle($auth_user, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la facture d'avoir pour la facture outbound numero "([^"]*)" est créée$/
     */
    public function laFactureDavoirPourLaFactureOutboundNumeroEstCreee(string $outboundInvoiceNumber)
    {
        $outboundInvoice = $this->outboundInvoiceRepository->findByNumber($outboundInvoiceNumber);

        $this->assertEquals(1, $this->outboundInvoiceRepository->findByParentId($outboundInvoice->getId())->count());
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise n\'a pas acces au module facturation$/
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
