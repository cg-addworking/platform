<?php

namespace Components\Contract\Contract\Tests\Acceptance\CalculateContractState;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Model\Application\Models\ContractModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateContractStateContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $contract;
    private $response;
    private $states = [
        "brouillon" => Contract::STATE_DRAFT,
        "en pr??paration" => Contract::STATE_IN_PREPARATION,
        "documents ?? fournir" => Contract::STATE_MISSING_DOCUMENTS,
        "bon pour mise en signature" => Contract::STATE_IS_READY_TO_GENERATE,
        "?? signer" => Contract::STATE_TO_SIGN,
        "sign??" => Contract::STATE_SIGNED,
        "actif" => Contract::STATE_ACTIVE,
        "??chu" => Contract::STATE_DUE,
        "inactif" => Contract::STATE_INACTIVE,
        "annul??" => Contract::STATE_CANCELED,
        "inconnu" => Contract::STATE_UNKNOWN,
    ];

    private $contractModelDocumentTypeRepository;
    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $contractPartRepository;
    private $contractPartyRepository;
    private $contractStateRepository;
    private $contractRepository;
    private $contractVariableRepository;
    private $documentTypeRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $legalFormRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelDocumentTypeRepository = new ContractModelDocumentTypeRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository();
        $this->contractPartRepository = new ContractPartRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractStateRepository = new ContractStateRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractVariableRepository = new ContractVariableRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->legalFormRepository = new LegalFormRepository;
    }

    /**
     * @Given /^les formes l??gales suivantes existent$/
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

            $enterprise->legalForm()->associate($this->legalFormRepository->findByName($item['legal_form_name']));
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
     * @Given /^les mod??les de contrat suivants existent$/
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
     * @Given /^les parties prenantes suivantes \(mod??le de contrat\) existent$/
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
     * @Given /^les pi??ces suivantes \(mod??le de contrat\) existent$/
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
     * @Given /^les variables suivantes \(pi??ces du mod??le de contrat\) existent$/
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
     * @Given /^les documents types suivantes \(parties prenantes du mod??le de contrat\) existent$/
     */
    public function lesDocumentsTypesSuivantesPartiesPrenantesDuModeleDeContratExistent(TableNode $contract_model_document_types)
    {
        foreach ($contract_model_document_types as $item) {
            $contract_model_document_type = $this->contractModelDocumentTypeRepository->make([
                'number' => $item['number'],
                'validation_required' => $item['validation_required'],
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
                'yousign_procedure_id' => isset($item['yousign_procedure_id'])
                        && $item['yousign_procedure_id']
                        !== 'null'
                        ? $item['yousign_procedure_id']
                        : null,
                'sent_to_signature_at' => $item['sent_to_signature_at'] !== 'null' ?
                    Carbon::createFromFormat('Y-m-d', $item['sent_to_signature_at']) :
                    null,
            ]);
            $contract_model = $item['contract_model_number'] ?
                $this->contractModelRepository->findByNumber($item['contract_model_number']) :
                null;
            $contract->contractModel()->associate($contract_model);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract->enterprise()->associate($enterprise);

            if($item['contract_parent_number'] !== 'null') {
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
     * @Given /^les pi??ces suivantes \(contrat\) existent$/
     */
    public function lesPiecesSuivantesContratExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = $this->contractPartRepository->make();
            $contract_part->fill([
                'number' => $item['number'],
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
     * @Given /^le contrat num??ro "([^"]*)" existe$/
     */
    public function leContratNumeroExiste($number)
    {
        $this->contract = $this->contractRepository->findByNumber($number);

        self::assertNotNull($this->contract);
    }

    /**
     * @Given /^il n\'a pas de parties prenantes\.$/
     */
    public function ilNaPasDePartiesPrenantes()
    {
        self::assertCount(0, $this->contractRepository->getSignatoryParties($this->contract));
    }

    /**
     * @When /^je calcule son ??tat\.$/
     */
    public function jeCalculeSonEtat()
    {
        $this->response = $this->contractStateRepository->getState($this->contract);
    }

    /**
     * @Then /^son ??tat est bien "([^"]*)"\.$/
     */
    public function sonEtatEstBien($state)
    {
        self::assertEquals($this->states[$state], $this->contractStateRepository->getState($this->contract));
    }

    /**
     * @Given /^il a au moins deux parties prenantes\.$/
     */
    public function ilAAuMoinsDeuxPartiesPrenantes()
    {
        self::assertTrue($this->contractRepository->getSignatoryParties($this->contract)->count() >= 2);
    }

    /**
     * @Given /^ces variables sont tous renseign??es$/
     */
    public function cesVariablesSontTousRenseignees()
    {
        self::assertTrue($this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($this->contract));
    }

    /**
     * @Given /^les documents du contrat ne sont pas tous valides$/
     */
    public function lesDocumentsDuContratNeSontPasTousValides()
    {
        self::assertFalse($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->contract));
    }

    /**
     * @Given /^ces variables ne sont pas tous renseign??es$/
     */
    public function cesVariablesNeSontPasTousRenseignees()
    {
        self::assertFalse($this->contractVariableRepository->checkIfAllRequiredVariablesHasValue($this->contract));
    }

    /**
     * @Given /^les documents du contrat sont valides$/
     */
    public function lesDocumentsDuContratSontValides()
    {
        self::assertTrue($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->contract));
    }

    /**
     * @Given /^le contrat n\'a pas de pi??ce non volante$/
     */
    public function leContratNaPasDePieceNonVolante()
    {
        self::assertFalse($this->contractRepository->checkIfHasPartsWithContractModel($this->contract));
    }

    /**
     * @Given /^le contrat a au moins une pi??ce non volante$/
     */
    public function leContratAAuMoinsUnePieceNonVolante()
    {
        self::assertTrue($this->contractRepository->checkIfHasPartsWithContractModel($this->contract));
    }

    /**
     * @Given /^les parties prenantes ont des dates de signatures renseign??es\.$/
     */
    public function lesPartiesPrenantesOntDesDatesDeSignaturesRenseignees()
    {
        foreach ($this->contractRepository->getSignatoryParties($this->contract) as $contract_part) {
            self::assertNotNull($contract_part->getSignedAt());
        }
    }

    /**
     * @Given /^la date de d??but du contrat est sup??rieur ou ??gale ?? la date du jour$/
     */
    public function laDateDeDebutDuContratEstSuperieurOuEgaleALaDateDuJour()
    {
        self::assertGreaterThanOrEqual(Carbon::now()->format('Y-m-d'), $this->contract->getValidFrom()->format('Y-m-d'));
    }

    /**
     * @Given /^la date du jour est comprise entre la date de d??but et la date de fin du contrat$/
     */
    public function laDateDuJourEstCompriseEntreLaDateDeDebutEtLaDateDeFinDuContrat()
    {
        self::assertTrue(
            Carbon::now()->isBetween(
                $this->contract->getValidFrom()->format('Y-m-d'),
                $this->contractRepository->getValidUntilDate($this->contract)->format('Y-m-d')
            )
        );
    }


    /**
     * @Given /^la date du jour est sup??rieur ou ??gale ?? la date de d??but du contrat$/
     */
    public function laDateDuJourEstSuperieurOuEgaleALaDateDeDebutDuContrat()
    {
        self::assertGreaterThanOrEqual($this->contract->getValidFrom()->format('Y-m-d'), Carbon::now()->format('Y-m-d'));
    }

    /**
     * @Given /^la date de fin du contrat n\'est pas d??finie$/
     */
    public function laDateDeFinDuContratNestPasDefinie()
    {
        self::assertNull($this->contract->getValidUntil());
    }

    /**
     * @Given /^la date de d??but du contrat n\'est pas d??finie$/
     */
    public function laDateDeDebutDuContratNestPasDefinie()
    {
        self::assertNull($this->contract->getValidFrom());
    }

    /**
     * @Given /^la date du jour est sup??rieure ou ??gale ?? la date de fin du contrat$/
     */
    public function laDateDuJourEstSuperieureOuEgaleALaDateDeFinDuContrat()
    {
        self::assertGreaterThanOrEqual(
            $this->contractRepository->getValidUntilDate($this->contract)->format('Y-m-d'),
            Carbon::now()->format('Y-m-d')
        );
    }

    /**
     * @Given /^il est annul??\.$/
     */
    public function ilEstAnnule()
    {
        self::assertNotNull($this->contract->getCanceledAt());
    }

    /**
     * @Given /^il est inactif\.$/
     */
    public function ilEstInactif()
    {
        self::assertNotNull($this->contract->getInactiveAt());
    }

    /**
     * @Given /^le contrat est pr??t ?? ??tre sign?? sur yousign$/
     */
    public function leContratEstPretAEtreSigneSurYousign()
    {
        self::assertNotNull($this->contract->getYousignProcedureId());
    }
}
