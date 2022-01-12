<?php

namespace Components\Contract\Contract\Tests\Acceptance\IdentifyParty;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\Exceptions\UserCantBeSignatoryOfContractPartyException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\UseCases\IdentifyParty;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdentifyPartyContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartyRepository;
    private $contractModelRepository;
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
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractRepository = new ContractRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractVariableRepository = new ContractVariableRepository();
        $this->contractStateRepository = new ContractStateRepository();
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
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = factory(ContractModel::class)->make([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes existent$/
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model_party = $this->contractModelPartyRepository->make([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les contracts suivants existent$/
     */
    public function lesContractsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
                'status' => $item['status'],
                'valid_from' => Carbon::createFromFormat('Y-m-d', $item['valid_from']),
                'valid_until' => Carbon::createFromFormat('Y-m-d', $item['valid_until']),
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
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
     * @When /^j\'essaie d\'identifier l\'entreprise "([^"]*)" comme partie prenante et l\'utilisateur avec l\'émail "([^"]*)" comme signataire du contrat numéro "([^"]*)"$/
     */
    public function jessaieDidentifierLentrepriseCommePartiePrenanteEtLutilisateurAvecLemailCommeSignataireDuContratNumero($siret, $email, $number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $enterprise = $this->enterpriseRepository->findBySiret($siret);
        $signatory = $this->userRepository->findByEmail($email);
        $contract = $this->contractRepository->findByNumber($number);
        $contract_model = $contract->getContractModel();
        $contract_model_party = $this->contractModelPartyRepository->findByOrder($contract_model, 1);

        $inputs = [
            'contract_model_party_id' => $contract_model_party->getId(),
            'enterprise_id' => $enterprise->id,
            'signatory_id' => $signatory->id,
            'denomination' => $contract_model_party->getDenomination(),
            'order' => $contract_model_party->getOrder(),
        ];

        try {
            $this->response = (new IdentifyParty(
                $this->contractPartyRepository,
                $this->contractModelPartyRepository,
                $this->enterpriseRepository,
                $this->contractRepository,
                $this->userRepository,
                $this->contractVariableRepository,
                $this->contractStateRepository
            ))->handle($auth_user, $contract, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'entreprise est identifiée comme partie prenante du contrat$/
     */
    public function lentrepriseEstIdentifieeCommePartiePrenanteDuContrat()
    {
        $this->assertDatabaseCount('addworking_contract_contract_parties', 1);
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
     * @Then /^une erreur est levée car l\'entreprise choisie n\'a aucune relation avec le contrat$/
     */
    public function uneErreurEstLeveeCarLentrepriseChoisieNaAucuneRelationAvecLeContrat()
    {
        $this->assertContainsEquals(
            EnterpriseDoesntHavePartnershipWithContractException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le signataire choisi n\'est pas signataire de l\'entreprise choisie comme partie prenante$/
     */
    public function uneErreurEstLeveeCarLeSignataireChoisiNestPasSignataireDeLentrepriseChoisieCommePartiePrenante()
    {
        $this->assertContainsEquals(
            UserCantBeSignatoryOfContractPartyException::class,
            $this->errors
        );
    }
}
