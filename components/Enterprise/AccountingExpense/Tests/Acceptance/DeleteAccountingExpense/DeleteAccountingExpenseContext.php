<?php

namespace Components\Enterprise\AccountingExpense\Tests\Acceptance\DeleteAccountingExpense;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MemberRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MilestoneRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MissionRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MissionTrackingLineRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MissionTrackingRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\UserRepository;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\AccountingExpenseHasMissionTrackingLinesException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsMissingTheFinancialRoleException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Enterprise\AccountingExpense\Domain\UseCases\DeleteAccountingExpense;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAccountingExpenseContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $accountingExpenseRepository;
    private $enterpriseRepository;
    private $memberRepository;
    private $milestoneRepository;
    private $missionRepository;
    private $missionTrackingRepository;
    private $missionTrackingLineRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->accountingExpenseRepository = new AccountingExpenseRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->memberRepository = new MemberRepository;
        $this->milestoneRepository = new MilestoneRepository;
        $this->missionRepository = new MissionRepository;
        $this->missionTrackingRepository = new MissionTrackingRepository;
        $this->missionTrackingLineRepository = new MissionTrackingLineRepository;
        $this->userRepository = new UserRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = $this->enterpriseRepository->make();
            $enterprise->fill([
                'name' => $item['name'],
                'identification_number' => $item['siret'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor'],
            ])->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());

            $enterprise->customers()->attach($this->enterpriseRepository->findBySiret($item['client_siret']));
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = factory(User::class)->create([
                'email' => $item['email'],
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id, ['is_financial' => $item['is_financial']]);
        }
    }

    /**
     * @Given /^les postes de dépense suivants existent$/
     */
    public function lesPostesDeDepenseSuivantsExistent(TableNode $accounting_expenses)
    {
        foreach ($accounting_expenses as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $this->accountingExpenseRepository
                ->make([
                    'number' => $item['number'],
                    'name' => $item['name'],
                    'display_name' => $item['display_name'],
                ])
                ->enterprise()->associate($enterprise)
                ->save();
        }
    }

    /**
     * @Given /^les missions suivantes existent$/
     */
    public function lesMissionsSuivantesExistent(TableNode $missions)
    {
        foreach ($missions as $item) {
            $this
                ->missionRepository
                ->make([
                    'number' => $item['number'],
                    'label' => $item['label'],
                    'status' => $item['status'],
                    'starts_at' => $item['starts_at'],
                ])
                ->customer()->associate($this->enterpriseRepository->findBySiret($item['client_siret']))
                ->vendor()->associate($this->enterpriseRepository->findBySiret($item['vendor_siret']))
                ->save();
        }
    }

    /**
     * @Given /^les milestones suivantes existent$/
     */
    public function lesMilestonesSuivantesExistent(TableNode $milestones)
    {
        foreach ($milestones as  $item) {
            $this
                ->milestoneRepository
                ->make([
                    'starts_at' => $item['starts_at'],
                    'ends_at' => $item['ends_at'],
                ])
                ->mission()->associate($this->missionRepository->findByNumber($item['mission_number']))
                ->save();
        }
    }

    /**
     * @Given /^les suivis de mission suivants existent$/
     */
    public function lesSuivisDeMissionSuivantsExistent(TableNode $mission_trackings)
    {
        foreach ($mission_trackings as $item) {
            $mission = $this->missionRepository->findByNumber($item['mission_number']);
            $this
                ->missionTrackingRepository
                ->make([
                    'number' => $item['number'],
                    'status' => $item['status'],
                    'description' => $item['description'],
                ])
                ->mission()->associate($mission)
                ->milestone()->associate($mission->milestones()->first())
                ->save();
        }
    }

    /**
     * @Given /^les lignes de suivis de mission suivantes existent$/
     */
    public function lesLignesDeSuivisDeMissionSuivantesExistent(TableNode $mission_tracking_lines)
    {
        foreach ($mission_tracking_lines as $item) {
            $this
                ->missionTrackingLineRepository
                ->make([
                    'label' => $item['label'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'unit' => $item['unit'],
                    'validation_vendor' => $item['validation_vendor'],
                    'validation_customer' => $item['validation_customer'],
                ])
                ->missionTracking()->associate($this->missionTrackingRepository->findByNumber($item['tracking_number']))
                ->accountingExpense()->associate($this->accountingExpenseRepository->findByNumber($item['accounting_expense_number']))
                ->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'émail "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de supprimer le poste de dépense numéro "([^"]*)" pour l\'entreprise avec le siret numéro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLePosteDeDepenseNumeroPourLentrepriseAvecLeSiretNumero($number, $siret)
    {
        $authenticated = $this->userRepository->connectedUser();
        $enterprise = $this->enterpriseRepository->findBySiret($siret);
        $accounting_expense = $this->accountingExpenseRepository->findByNumber($number);

        try {
            $this->response = (new DeleteAccountingExpense(
                $this->accountingExpenseRepository,
                $this->memberRepository,
                $this->userRepository
            ))->handle($authenticated, $enterprise, $accounting_expense);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le poste de dépense numéro "([^"]*)" est supprimé$/
     */
    public function lePosteDeDepenseNumeroEstSupprime($number)
    {
        self::assertTrue($this->response);

        self::assertTrue($this->accountingExpenseRepository->isDeleted($number));
    }

    /**
     * @Then /^une erreur est levée car je n\'ai pas le rôle financier$/
     */
    public function uneErreurEstLeveeCarJeNaiPasLeRoleFinancier()
    {
        self::assertContainsEquals(
            UserIsMissingTheFinancialRoleException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car je ne suis pas membre de l\'entreprise$/
     */
    public function uneErreurEstLeveeCarJeNeSuisPasMembreDeLentreprise()
    {
        self::assertContainsEquals(
            UserIsNotMemberOfThisEnterpriseException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le poste de dépense a des lignes de suivi de mission associées$/
     */
    public function uneErreurEstLeveeCarLePosteDeDepenseADesLignesDeSuiviDeMissionAssociees()
    {
        self::assertContainsEquals(
            AccountingExpenseHasMissionTrackingLinesException::class,
            $this->errors
        );
    }

}
