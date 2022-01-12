<?php

namespace Components\Enterprise\AccountingExpense\Tests\Acceptance\EditAccountingExpense;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MemberRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\UserRepository;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsMissingTheFinancialRoleException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Enterprise\AccountingExpense\Domain\UseCases\EditAccountingExpense;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditAccountingExpenseContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $accountingExpenseRepository;
    private $enterpriseRepository;
    private $memberRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->accountingExpenseRepository = new AccountingExpenseRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->memberRepository = new MemberRepository;
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'émail "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de modifier le poste de dépense numéro "([^"]*)" pour l\'entreprise avec le siret numéro "([^"]*)"$/
     */
    public function jessaieDeModifierLePosteDeDepenseNumeroPourLentrepriseAvecLeSiretNumero($number, $siret)
    {
        $authenticated = $this->userRepository->connectedUser();
        $enterprise = $this->enterpriseRepository->findBySiret($siret);
        $accounting_expense = $this->accountingExpenseRepository->findByNumber($number);

        $inputs = [
            'display_name' => 'This is a display name',
            'analytical_code' => 'this-is-an-analytical-code',
        ];

        try {
            $this->response = (new EditAccountingExpense(
                $this->accountingExpenseRepository,
                $this->memberRepository,
                $this->userRepository
            ))->handle($authenticated, $enterprise, $accounting_expense, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le poste de dépense est modifié$/
     */
    public function lePosteDeDepenseEstModifie()
    {
        $this->assertDatabaseHas('addworking_enterprise_accounting_expenses', [
            'enterprise_id' => $this->response->getEnterprise()->id,
            'name' => $this->response->getName(),
            'display_name' => $this->response->getDisplayName(),
            'analytical_code' => $this->response->getAnalyticalCode(),
        ]);
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
}
