<?php

namespace Components\Contract\Contract\Tests\Acceptance\IdentifyValidator;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\UseCases\IdentifyValidator;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdentifyValidatorContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelPartRepository;
    private $contractPartyRepository;
    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractVariableRepository;
    private $contractStateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractRepository = new ContractRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractVariableRepository = new ContractVariableRepository();
        $this->contractStateRepository = new ContractStateRepository();
    }

    /**
     * @Given /^les formes légales suivantes existent$/
     */
    public function lesFormesLegalesSuivantesExistent(TableNode $legal_Forms)
    {
        foreach ($legal_Forms as $item) {
            $legal_Form = new LegalForm;
            $legal_Form->fill([
                'name'         => $item['legal_form_name'],
                'display_name' => $item['display_name'],
                'country'      => $item['country'],
            ]);
            $legal_Form->save();
        }
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
            $enterprise->users()->updateExistingPivot($user->id,['is_signatory' => $item['is_signatory']]);
        }
    }

    /**
     * @Given les parties prenantes du modèle suivantes existent
     */
    public function lesPartiesPrenantesDuModeleSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_party = new ContractModelParty();
            $contract_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les modèles de contrat suivant existe$/
     */
    public function lesModelesDeContratSuivantExiste(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = factory(ContractModel::class)->make([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes existent$/
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract_party = $this->contractPartyRepository->make();
            $contract_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_party->contract()->associate($contract)->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_party->enterprise()->associate($enterprise)->save();

            $contract_model_party = $this->contractModelPartyRepository
                ->findByNumber($item['contract_model_party_number']);
            $contract_party->contractModelParty()->associate($contract_model_party)->save();

            $user = $this->userRepository->findByEmail($item['email']);
            $contract_party->signatory()->associate($user)->save();
        }
    }

    /**
     * @Given /^les pièces du modèle suivantes existent$/
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_part = $this->contractModelPartRepository->make();
            $contract_part->fill([
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'order' => $item['order'],
                'number' => $item['number'],
                'should_compile' => $item['should_compile'],
            ]);

            $file = factory(File::class)->create([
                "mime_type" => "text/html",
                "path" => sprintf('%s.%s', uniqid('/tmp/'), 'html'),
                "content" => "<html><body><p>{{1.variable1}}</p><p>{{1.variable2}}</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les contrats suivants existent$/
     */
    public function lesContratsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise);

            $contract->save();
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
     * @When /^j\'essaie d\'identifier l\'utilisateur avec l\'email "([^"]*)" comme validateur du contrat numéro "([^"]*)"$/
     */
    public function jessaieDidentifierLutilisateurAvecLemailCommeValidateurDuContratNumero($email, $contract_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract = $this->contractRepository->findByNumber($contract_number);
        $validator = $this->userRepository->findByEmail($email);
        $order = 0;
        $validator_id = $validator->id;
        try {
            $this->response = (new IdentifyValidator(
                $this->contractPartyRepository,
                $this->userRepository
            ))->handle($auth_user, $contract, $order, $validator_id);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'utilisateur est identifiée comme validateur du contrat$/
     */
    public function lutilisateurEstIdentifieeCommeValidateurDuContrat()
    {
        $this->assertDatabaseHas('addworking_contract_contract_parties', [
            'is_validator' => 1,
        ]);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas membre de l\'entreprise propriétaire du contrat$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasMembreDeLentrepriseProprietaireDuContrat()
    {
        $this->assertContainsEquals(
            UserIsNotMemberOfTheContractEnterpriseException::class,
            $this->errors
        );
    }

    /**
     * @Then /^aucun utilisateur n\'est identifié en tan que validateur du contrat$/
     */
    public function aucunUtilisateurNestIdentifieEnTanQueValidateurDuContrat()
    {
        $this->assertDatabaseMissing('addworking_contract_contract_parties', [
            'is_validator' => 1,
        ]);
    }
}
