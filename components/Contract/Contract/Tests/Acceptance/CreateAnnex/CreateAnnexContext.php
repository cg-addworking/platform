<?php

namespace Components\Contract\Contract\Tests\Acceptance\CreateAnnex;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Barryvdh\DomPDF\Facade as PDF;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\UseCases\CreateAnnex;
use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Contract\Contract\Application\Repositories\UserRepository;

class CreateAnnexContext extends TestCase implements Context
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
            $user = factory(User::class)->create([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
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
     * @When /^j\'essaie de créer une annexe pour mon entreprise$/
     */
    public function jessaieDeCreerUneAnnexePourMonEntreprise()
    {
        $auth_user = $this->userRepository->connectedUser();

        $pdf = PDF::loadHTML('
            <img src="img/logo_addworking_vertical.png">
            <h1><div style="text-align: center;">Test annex pdf</div></h1>
        ');

        $file = factory(File::class)->create([
            'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
            'mime_type' => 'application/pdf',
            'content'   => @$pdf->output()
        ]);

        $input = ['name' => 'Warlock was here', 'description' => 'description one'];

        try {
            $this->response = (new CreateAnnex(
                $this->userRepository,
                $this->annexRepository
            ))->handle($auth_user, $auth_user->enterprise, $file, $input);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'annexe est créé$/
     */
    public function lannexeEstCree()
    {
        $this->assertDatabaseHas('addworking_contract_annexes', [
            'name' => $this->response->getName(),
            'display_name' => $this->response->getDisplayName(),
        ]);
        $this->assertDatabaseCount('addworking_contract_annexes', 1);
    }

    /**
     * @Then /^une erreur est levée car je ne suis pas membre du support$/
     */
    public function uneErreurEstLeveeCarJeNeSuisPasMembreDuSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

}
