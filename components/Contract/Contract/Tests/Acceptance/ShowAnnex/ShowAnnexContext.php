<?php

namespace Components\Contract\Contract\Tests\Acceptance\ShowAnnex;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Domain\Exceptions\AnnexIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrMemberOfTheAnnexEnterpriseException;
use Components\Contract\Contract\Domain\UseCases\ShowAnnex;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Exception;

class ShowAnnexContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $annexRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->annexRepository = new AnnexRepository();
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
                'gender'         => array_random(['male', 'female']),
                'password'       => Hash::make('password'),
                'remember_token' => str_random(10),
                'email' => $item['email'],
                'firstname'=> $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);
            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given les annexes suivantes existent
     */
    public function lesAnnexesSuivantesExistent(TableNode $annexes)
    {
        foreach ($annexes  as $item) {
            $annex = new Annex();

            $annex->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['name'],
                'description' => $item['description'],

            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $annex->setEnterprise($enterprise);

            $file = factory(File::class)->create();
            $annex->setFile($file);

            $annex->save();
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
     * @When j'essaie de voir le détail de l'annexe numéro :arg1
     */
    public function jessaieDeVoirLeDetailDeLannexeNumero(int $annex_number)
    {
        $annex = $this->annexRepository->findByNumber($annex_number);
        $auth_user  = $this->userRepository->connectedUser();

        try {
            $this->response = (new ShowAnnex($this->userRepository))->handle($auth_user, $annex);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le détail de l'annexe numéro :arg1 est affiché
     */
    public function leDetailDeLannexeNumeroEstAffiche(int $annex_number)
    {
        $annex = $this->annexRepository->findByNumber($annex_number);

        $this->assertEquals($annex->getNumber(), $this->response->getNumber());
    }

    /**
     * @Then une erreur est levée car l'utilisateur n'est pas support ou membre de l'entreprise propriétaire de l'annexe
     */
    public function uneErreurEstLeveeCarLutilisateurNestPasSupportOuMembreDeLentrepriseProprietaireDeLannexe()
    {
        $this->assertContainsEquals(
            UserIsNotSupportOrMemberOfTheAnnexEnterpriseException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car l'annexe n'existe pas
     */
    public function uneErreurEstLeveeCarLannexeNexistePas()
    {
        $this->assertContainsEquals(
            AnnexIsNotFoundException::class,
            $this->errors
        );
    }

}