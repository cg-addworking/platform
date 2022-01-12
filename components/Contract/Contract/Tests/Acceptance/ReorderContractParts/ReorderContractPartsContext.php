<?php

namespace Components\Contract\Contract\Tests\Acceptance\ReorderContractParts;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractPartOrderIsFirstOneException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartOrderIsLastOneException;
use Components\Contract\Contract\Domain\UseCases\ReorderContractParts;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReorderContractPartsContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $contract;
    private $errors = [];
    private $response;
    private $directions = [
        "haut" => ContractPart::ORDER_UP,
        "bas" => ContractPart::ORDER_DOWN,
    ];

    private $contractModelDocumentTypeRepository;
    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $contractPartRepository;
    private $contractPartyRepository;
    private $contractRepository;
    private $contractVariableRepository;
    private $documentTypeRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $legalFormRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelDocumentTypeRepository = new ContractModelDocumentTypeRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelVariableRepository = new ContractModelVariableRepository;
        $this->contractPartRepository = new ContractPartRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractRepository = new ContractRepository;
        $this->contractVariableRepository = new ContractVariableRepository;
        $this->documentTypeRepository = new DocumentTypeRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->legalFormRepository = new LegalFormRepository;
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

            $enterprise
                ->legalForm()->associate($this->legalFormRepository->findByName($item['legal_form_name']))
                ->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']))
                ->save();

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
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id, ['is_signatory' => $item['is_signatory']]);
        }
    }

    /**
     * @Given /^les documents types suivants existent$/
     */
    public function lesDocumentsTypesSuivantsExistent(TableNode $document_types)
    {
        foreach ($document_types as $item) {
            $document_type = new DocumentType([
                'display_name' => $item['display_name'],
                'name' => $item['display_name'],
                'description' => $item['description'],
                'is_mandatory' => $item['is_mandatory'],
                'validity_period' => $item['validity_period'],
                'code' => $item['code'],
                'type' => $item['type'],
            ]);

            $entreprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $document_type->enterprise()->associate($entreprise)->save();

            $document_type->legalForms()->attach($this->legalFormRepository->findByName($item['legal_form_name']));
        }
    }

    /**
     * @Given /^les documents suivants existent$/
     */
    public function lesDocumentsSuivantsExistent(TableNode $documents)
    {
        foreach ($documents as $item) {
            $document = factory(Document::class)->make();
            $document->fill([
                'valid_from' => $item['valid_from'],
                'status' => $item['status'],
            ]);

            $type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);

            $document
                ->documentType()->associate($type)
                ->enterprise()->associate($enterprise)
                ->save();
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
                'published_at' => $item['published_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes \(modèle de contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesModeleDeContratExistent(TableNode $contract_model_parties)
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
     * @Given /^les pièces suivantes \(modèle de contrat\) existent$/
     */
    public function lesPiecesSuivantesModeleDeContratExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_model_part = $this->contractModelPartRepository->make([
                'display_name' => $item['display_name'],
                'name' => $item['display_name'],
                'is_initialled' => $item['is_initialled'],
                'is_signed' => $item['is_signed'],
                'should_compile' => $item['should_compile'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les variables suivantes \(pièces du modèle de contrat\) existent$/
     */
    public function lesVariablesSuivantesPiecesDuModeleDeContratExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name' => $item['name'],
                'number' => $item['number'],
                'order'  => 0,
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_variable->contractModel()->associate($contract_model);

            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $contract_model_variable->contractModelParty()->associate($contract_model_party);

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['contract_model_part_number']);
            $contract_model_variable->setContractModelPart($contract_model_part);
            $contract_model_variable->save();
        }
    }

    /**
     * @Given /^les documents types suivantes \(parties prenantes du modèle de contrat\) existent$/
     */
    public function lesDocumentsTypesSuivantesPartiesPrenantesDuModeleDeContratExistent(TableNode $contract_model_document_types)
    {
        foreach ($contract_model_document_types as $item) {
            $contract_model_document_type = $this->contractModelDocumentTypeRepository->make([
                'number' => $item['number'],
            ]);

            $document_type = DocumentType::where('display_name', $item['document_type_display_name'])->first();
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);

            $contract_model_document_type
                ->documentType()->associate($document_type)
                ->contractModelParty()->associate($contract_model_party)
                ->save();
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
                'valid_from' => $item['valid_from'] !== 'null' ?
                    Carbon::createFromFormat('Y-m-d', $item['valid_from']) :
                    null,
                'valid_until' => $item['valid_until'] !== 'null' ?
                    Carbon::createFromFormat('Y-m-d', $item['valid_until']) :
                    null,
                'canceled_at' => $item['canceled_at'] !== 'null' ?
                    Carbon::createFromFormat('Y-m-d', $item['canceled_at']) :
                    null,
                'inactive_at' => $item['inactive_at'] !== 'null' ?
                    Carbon::createFromFormat('Y-m-d', $item['inactive_at']) :
                    null,
                'yousign_procedure_id' => $item['yousign_procedure_id'] !== 'null' ?
                    $item['yousign_procedure_id'] :
                    null,
            ]);
            $contract_model = $item['contract_model_number'] ?
                $this->contractModelRepository->findByNumber($item['contract_model_number']) :
                null;
            $contract->contractModel()->associate($contract_model);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract->enterprise()->associate($enterprise);

            if ($item['contract_parent_number'] !== 'null') {
                $contract_parent = $this->contractRepository->findByNumber($item['contract_parent_number']);
                $contract->parent()->associate($contract_parent);
            }

            $contract->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes \(contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesContratExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $signatory = $this->userRepository->findByNumber($item['signatory_number']);

            $contract_party = $this->contractPartyRepository->make([
                'number' => $item['number'],
                'denomination' => $contract_model_party->getDenomination(),
                'order' => $item['order'],
                'enterprise_name' => $enterprise->name,
                'signatory_name' => $signatory->name,
                'signed' => $item['signed'],
                'signed_at' => $item['signed_at'] !== 'null' ? Carbon::createFromFormat('Y-m-d', $item['signed_at']) : null,
            ]);
            $contract_party
                ->contract()->associate($contract)
                ->contractModelParty()->associate($contract_model_party)
                ->enterprise()->associate($enterprise)
                ->signatory()->associate($signatory)
                ->save();
        }
    }

    /**
     * @Given /^les pièces suivantes \(contrat\) existent$/
     */
    public function lesPiecesSuivantesContratExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = $this->contractPartRepository->make();
            $contract_part->fill([
                'number' => $item['number'],
                'order' => $item['order'],
                'is_hidden' => $item['is_hidden'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_part->contract()->associate($contract);

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['contract_model_part_number']);
            $contract_part->contractModelPart()->associate($contract_model_part);

            $contract_part->file()->associate(factory(File::class)->create());
            $contract_part->save();
        }
    }

    /**
     * @Given /^les variables suivantes \(contrat\) existent$/
     */
    public function lesVariablesSuivantesContratExistent(TableNode $contract_variables)
    {
        foreach ($contract_variables as $item) {
            $contract_variable = $this->contractVariableRepository->make([
                'number' => $item['number'],
                'value' => $item['value'] !== 'null' ? $item['value'] : null,
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_model_variable = $this->contractModelVariableRepository->findByNumber($item['contract_model_variable_number']);
            $contract_party = $this->contractPartyRepository->findByNumber($item['contract_party_number']);

            $contract_variable
                ->contract()->associate($contract)
                ->contractModelVariable()->associate($contract_model_variable)
                ->contractParty()->associate($contract_party)
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
     * @Given /^le contrat numéro "([^"]*)" existe$/
     */
    public function leContratNumeroExiste($number)
    {
        $this->contract = $this->contractRepository->findByNumber($number);

        self::assertNotNull($this->contract);
    }

    /**
     * @Given /^il a au moins deux parties prenantes\.$/
     */
    public function ilAAuMoinsDeuxPartiesPrenantes()
    {
        self::assertTrue($this->contractRepository->getSignatoryParties($this->contract)->count() >= 2);
    }

    /**
     * @Given /^ses variables sont tous renseignées$/
     */
    public function sesVariablesSontTousRenseignees()
    {
        self::assertTrue($this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($this->contract));
    }

    /**
     * @Given /^les documents du contrat sont valides$/
     */
    public function lesDocumentsDuContratSontValides()
    {
        self::assertFalse($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->contract));
    }

    /**
     * @Given /^le contrat a au moins deux pièces non volantes$/
     */
    public function leContratAAuMoinsDeuxPiecesNonVolantes()
    {
        self::assertTrue($this->contractRepository->checkIfHasPartsWithContractModel($this->contract));
    }

    /**
     * @When /^je change l\'ordre de la pièce numéro "([^"]*)" vers le "([^"]*)"$/
     */
    public function jeChangeLordreDeLaPieceNumeroVersLe($number, $direction)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_part = $this->contractPartRepository->findByNumber($number);

        try {
            $this->response = (new ReorderContractParts(
                $this->contractPartRepository,
                $this->contractRepository
            ))->handle($auth_user, $this->directions[$direction], $contract_part);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'ordre de la pièce numéro "([^"]*)" devient "([^"]*)"$/
     */
    public function lordreDeLaPieceNumeroDevient($number, $order)
    {
        $contract_part = $this->contractPartRepository->findByNumber($number);
        self::assertEquals($order, $contract_part->getOrder());
    }

    /**
     * @Then /^l\'ordre des autres pièces du contrat numéro "([^"]*)" a été adapté$/
     */
    public function lordreDesAutresPiecesDuContratNumeroAEteAdapte($number)
    {
        $contract_part = $this->contractPartRepository->findByNumber($number);

        $order = 1;
        foreach ($this->contractRepository->getContractParts($contract_part->getContract())->sortBy('order') as $part) {
            self::assertEquals($order, $part->getOrder());
            $order++;
        }
    }

    /**
     * @Then /^une erreur est survenue car l\'ordre de la pièce est le dernier par rapport aux pièces non cachés$/
     */
    public function uneErreurEstSurvenueCarLordreDeLaPieceEstLeDernierParRapportAuxPiecesNonCaches()
    {
        self::assertContainsEquals(
            ContractPartOrderIsLastOneException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est survenue car l\'ordre de la pièce est le premier$/
     */
    public function uneErreurEstSurvenueCarLordreDeLaPieceEstLePremier()
    {
        self::assertContainsEquals(
            ContractPartOrderIsFirstOneException::class,
            $this->errors
        );
    }
}
