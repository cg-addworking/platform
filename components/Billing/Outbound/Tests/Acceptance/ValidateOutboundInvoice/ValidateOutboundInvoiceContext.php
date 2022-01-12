<?php
namespace Components\Billing\Outbound\Tests\Acceptance\ValidateOutboundInvoice;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\MemberRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceStatusIsNotFileGeneratedException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\UseCases\ValidateOutboundInvoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Exception;

class ValidateOutboundInvoiceContext extends TestCase implements Context
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
     * @Given les entreprises suivantes existent
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
                'gender'         => array_random(['male', 'female']),
                'password'       => Hash::make('password'),
                'remember_token' => str_random(10),
                'email' => $item['email'],
                'firstname'=> $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);
            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given les échéances de paiement suivantes existent
     */
    public function lesEcheancesDePaiementSuivantesExistent2(TableNode $deadlines)
    {
        foreach ($deadlines as $item) {
            $deadline = new DeadlineType();

            $deadline->fill([
                'name'         => str_slug($item['display_name'], '_'),
                'display_name' => $item['display_name'],
                'value'        => $item['value'],
                'description'  => $item['description'],
            ])->save();
        }
    }

    /**
     * @Given les factures outbound suivantes existent
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
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de valider la facture numéro :arg1
     */
    public function jessaieDeValiderLaFactureNumero($number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($number);

        try {
            $this->response = (new ValidateOutboundInvoice(
                $this->outboundInvoiceRepository,
                $this->userRepository,
            ))->handle($auth_user, $outbound_invoice);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then la facture numéro :arg1 est validée
     */
    public function laFactureNumeroEstValidee($number)
    {
        $outbound_invoice = $this->outboundInvoiceRepository->findByNumber($number);

        $this->assertEquals($outbound_invoice->getStatus(), $this->response->status);
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas support
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(UserIsNotSupportException::class, $this->errors);
    }

    /**
     * @Then une erreur est levée car son état est différent de file_generated
     */
    public function uneErreurEstLeveeCarSonEtatEstDifferentDeFileGenerated()
    {
        $this->assertContainsEquals(OutboundInvoiceStatusIsNotFileGeneratedException::class, $this->errors);
    }
}
