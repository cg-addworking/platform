<?php

namespace Components\Contract\Contract\Tests\Acceptance\DeleteAnnex;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Barryvdh\DomPDF\Facade as PDF;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\AnnexIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\UseCases\DeleteAnnex;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAnnexContext extends TestCase implements Context
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
                'is_vendor' => $item['is_vendor']
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));

            $enterprise->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());
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
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^annexes suivantes existent$/
     */
    public function annexesSuivantesExistent(TableNode $annexes)
    {
        foreach ($annexes as $item) {
            $annex = $this->annexRepository->make();
            $annex->fill([
                'name' => $item['display_name'],
                'display_name' => $item['display_name'],
                'number' => $item['number'],
            ]);

            $pdf = PDF::loadHTML('
                <img src="img/logo_addworking_vertical.png">
                <h1><div style="text-align: center;">Test annex pdf</div></h1>
            ');
            $file = factory(File::class)->create([
                'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
                'mime_type' => 'application/pdf',
                'content'   => @$pdf->output()
            ]);
            $annex->setFile($this->annexRepository->createFile($file));

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $annex->setEnterprise($enterprise);

            $this->annexRepository->save($annex);
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
     * @When /^j\'essaie de supprimer l\'annex "([^"]*)"$/
     */
    public function jessaieDeSupprimerLannex($number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $annex = $this->annexRepository->findByNumber($number);

        try {
            $this->response = (new DeleteAnnex(
                $this->annexRepository,
                $this->userRepository
            ))->handle($auth_user, $annex);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'annexe "([^"]*)" est supprimé$/
     */
    public function lannexeEstSupprime($number)
    {
        $this->assertTrue($this->response);

        $this->assertTrue($this->annexRepository->isDeleted($number));
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

    /**
     * @Then /^une erreur est levée car l\'annexe n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLannexeNexistePas()
    {
        $this->assertContainsEquals(
            AnnexIsNotFoundException::class,
            $this->errors
        );
    }
}
