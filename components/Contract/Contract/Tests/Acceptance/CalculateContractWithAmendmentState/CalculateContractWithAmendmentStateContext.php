<?php

namespace Components\Contract\Contract\Tests\Acceptance\CalculateContractWithAmendmentState;

use App\Models\Addworking\Common\Address;
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
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateContractWithAmendmentStateContext extends TestCase implements Context
{
    use RefreshDatabase;

    private ContractEntityInterface $contract;
    private ContractEntityInterface $amendment;

    private $response;
    private $states = [
        "brouillon" => Contract::STATE_DRAFT,
        "bon pour mise en signature" => Contract::STATE_IS_READY_TO_GENERATE,
        "à signer" => Contract::STATE_TO_SIGN,
        "signé" => Contract::STATE_SIGNED,
        "actif" => Contract::STATE_ACTIVE,
        "échu" => Contract::STATE_DUE,
        "inactif" => Contract::STATE_INACTIVE,
        "annulé" => Contract::STATE_CANCELED,
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
     * @Given /^le contrat existe$/
     */
    public function leContratExiste()
    {
        $this->contract = $this->createContract();
    }

    /**
     * @Given /^le contrat a un avenant$/
     */
    public function leContratAUnAvenant()
    {
        $this->amendment = $this->createContract($this->contract);
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertFalse($this->contract->getAmendments()->isEmpty());
    }

    /**
     * @Given /^l\'avenant existe$/
     */
    public function lavenantExiste()
    {
        self::assertNotNull($this->amendment);
        self::assertNotNull($this->amendment->getParent());
    }

    private function createContract($contract_parent = null)
    {
        $enterprise = $this->enterpriseRepository->findBySiret('02000000000000');

        $contract_model = $this->contractModelRepository->make();
        $contract_model->setNumber();
        $contract_model->setEnterprise($enterprise);
        $contract_model->setName('contract_model');
        $contract_model->setDisplayName('contract_model');
        $contract_model = $this->contractModelRepository->save($contract_model);

        for ($i = 0; $i != 2; $i++) {
            $contract_model_party = $this->contractModelPartyRepository->make();
            $contract_model_party->setOrder($i);
            $contract_model_party->setNumber();
            $contract_model_party->setDenomination('denomination');
            $contract_model_party->setContractModel($contract_model);
            $this->contractModelPartyRepository->save($contract_model_party);
        }

        $contract_model_part = $this->contractModelPartRepository->make();
        $contract_model_part->setNumber();
        $contract_model_part->setOrder(0);
        $contract_model_part->setName('part');
        $contract_model_part->setDisplayName('part');
        $contract_model_part->setContractModel($contract_model);
        $this->contractModelPartRepository->save($contract_model_part);

        $contract_model_variable = $this->contractModelVariableRepository->make();
        $contract_model_variable->setNumber();
        $contract_model_variable->setName('var1');
        $contract_model_variable->setOrder(0);
        $contract_model_variable->setContractModelParty($contract_model_party);
        $contract_model_variable->setContractModel($contract_model);
        $contract_model_variable->setContractModelPart($contract_model_part);
        $contract_model_variable->save();

        $document_type = DocumentType::where(
            'display_name',
            'document type '. (is_null($contract_parent) ? '1' : '2')
        )->first();
        $contract_model_document_type = $this->contractModelDocumentTypeRepository->make();
        $contract_model_document_type->setNumber();
        $contract_model_document_type->setContractModelParty($contract_model_party);
        $contract_model_document_type->setValidationRequired(true);
        $contract_model_document_type->setDocumentType($document_type);
        $this->contractModelDocumentTypeRepository->save($contract_model_document_type);

        $contract = $this->contractRepository->make();
        $contract->setName('contract');
        $contract->setNumber();
        $contract->setContractModel($contract_model);
        if (!is_null($contract_parent)) {
            $contract->setParent($contract_parent);
        }
        $this->contractRepository->save($contract);

        $contract_part = $this->contractPartRepository->make();
        $contract_part->setName('contract_part');
        $contract_part->setNumber();
        $contract_part->setOrder(1);
        $contract_part->setContract($contract);
        $this->contractPartRepository->save($contract_part);

        return $contract;
    }

    /**
     * @Given /^le contrat a au moins deux parties prenantes\.$/
     */
    public function leContratAAuMoinsDeuxPartiesPrenantes()
    {
        foreach ($this->contract->getContractModel()->getParties() as $model_party) {
            $enterprise = $this->enterpriseRepository->findBySiret('02000000000000');
            $signatory = $this->userRepository->findByNumber(2);

            $contract_party = $this->contractPartyRepository->make([
                'denomination' => 'denomination',
                'order' => $model_party->getOrder(),
                'enterprise_name' => $enterprise->name,
                'signatory_name' => $signatory->name,
                'signed' => true,
            ]);
            $contract_party->setNumber();
            $contract_party->setContractModelParty($model_party);
            $contract_party
                ->contract()->associate($this->contract)
                ->enterprise()->associate($enterprise)
                ->signatory()->associate($signatory)
                ->save();
            $this->contractPartyRepository->save($contract_party);
        }
        self::assertTrue($this->contract->getParties()->count() === 2);
    }

    /**
     * @Given /^l\'avenant n\'a pas de parties prenantes\.$/
     */
    public function lavenantNaPasDePartiesPrenantes()
    {
        self::assertTrue($this->amendment->getParties()->isEmpty());
    }

    /**
     * @Given /^l\'avenant a au moins deux parties prenantes\.$/
     */
    public function lavenantAAuMoinsDeuxPartiesPrenantes()
    {
        foreach ($this->amendment->getContractModel()->getParties() as $model_party) {
            $enterprise = $this->enterpriseRepository->findBySiret('02000000000000');
            $signatory = $this->userRepository->findByNumber(2);

            $contract_party = $this->contractPartyRepository->make([
                'denomination' => 'denomination',
                'order' => $model_party->getOrder(),
                'enterprise_name' => $enterprise->name,
                'signatory_name' => $signatory->name,
                'signed' => true,
            ]);
            $contract_party->setNumber();
            $contract_party->setContractModelParty($model_party);
            $contract_party
                ->contract()->associate($this->amendment)
                ->enterprise()->associate($enterprise)
                ->signatory()->associate($signatory)
                ->save();
            $this->contractPartyRepository->save($contract_party);
        }
        self::assertTrue($this->amendment->getParties()->count() === 2);
    }

    /**
     * @Given /^les parties prenantes de l\'avenant ont des dates de signatures renseignées\.$/
     */
    public function lesPartiesPrenantesDeLavenantOntDesDatesDeSignaturesRenseignees()
    {
        $now = Carbon::now();
        foreach ($this->amendment->getParties() as $contract_party) {
            /* @var ContractParty $contract_party */
            $contract_party->setSignedAt($now);
            $this->contractPartyRepository->save($contract_party);
        }

        foreach ($this->amendment->getParties() as $contract_party) {
            self::assertNotNull($contract_party->getSignedAt());
        }
    }

    /**
     * @Given /^les parties prenantes du contrat ont des dates de signatures renseignées\.$/
     */
    public function lesPartiesPrenantesDuContratOntDesDatesDeSignaturesRenseignees()
    {
        $now = Carbon::now();
        foreach ($this->contract->getParties() as $contract_party) {
            /* @var ContractParty $contract_party */
            $contract_party->setSignedAt($now);
            $this->contractPartyRepository->save($contract_party);
        }

        foreach ($this->contract->getParties() as $contract_party) {
            self::assertNotNull($contract_party->getSignedAt());
        }
    }

    /**
     * @Given /^les variables du contrat sont toutes renseignées$/
     */
    public function lesVariablesDuContratSontToutesRenseignees()
    {
        foreach ($this->contract->getContractVariables() as $variable)
        {
            /* @var ContractVariable $variable */
            $variable->setValue('random_value');
            $this->contractVariableRepository->save($variable);
        }
    }

    /**
     * @Given /^les variables de l\'avenant sont tous renseignées$/
     */
    public function lesVariablesDeLavenantSontTousRenseignees()
    {
        foreach ($this->amendment->getContractVariables() as $variable)
        {
            /* @var ContractVariable $variable */
            $variable->setValue('random_value');
            $this->contractVariableRepository->save($variable);
        }
    }

    /**
     * @Given /^les variables de l\'avenant ne sont pas tous renseignées$/
     */
    public function lesVariablesDeLavenantNeSontPasTousRenseignees()
    {
        foreach ($this->amendment->getContractVariables() as $variable)
        {
            /* @var ContractVariable $variable */
            self::assertNull($variable->getValue());
        }
    }

    /**
     * @Given /^les documents de l\'avenant sont valides$/
     */
    public function lesDocumentsDeLavenantSontValides()
    {
        $document = factory(Document::class)->make([
            'status' => 'validated',
            'valid_until' => '01-01-2022',
        ]);

        $docType = $this->documentTypeRepository->findByNameAndEnterprise(
            'document_type2',
            $this->enterpriseRepository->findBySiret('02000000000000')
        );

        $document->documentType()->associate($docType);
        $enterprise = $this->enterpriseRepository->findBySiret('02000000000000');
        $document->enterprise()->associate($enterprise);
        $document->save();

        self::assertTrue($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->amendment));
    }

    /**
     * @Given /^les documents du contrat sont valides$/
     */
    public function lesDocumentsDuContratSontValides()
    {
        $document = factory(Document::class)->make([
            'status' => 'validated',
            'valid_until' => '01-01-2042',
        ]);

        $docType = $this->documentTypeRepository->findByNameAndEnterprise(
            'document_type1',
            $this->enterpriseRepository->findBySiret('02000000000000')
        );

        $document->documentType()->associate($docType);
        $enterprise = $this->enterpriseRepository->findBySiret('02000000000000');
        $document->enterprise()->associate($enterprise);
        $document->save();

        self::assertTrue($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->contract));
    }

    /**
     * @Given /^les documents du contrat ne sont pas tous valides$/
     */
    public function lesDocumentsDuContratNeSontPasTousValides()
    {
        self::assertFalse($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->contract));
    }

    /**
     * @Given /^les documents de l\'avenant ne sont pas tous valides$/
     */
    public function lesDocumentsDeLavenantNeSontPasTousValides()
    {
        self::assertFalse($this->contractRepository->checkIfAllDocumentsOfContractStatusIsValidated($this->amendment));
    }

    /**
     * @When /^je calcule l\'état du contrat$/
     */
    public function jeCalculeLetatDuContrat()
    {
        $this->contract = Contract::find($this->contract->getId());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Then /^l\'état du contrat est "([^"]*)"\.$/
     */
    public function letatDuContratEst($state)
    {
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
        self::assertEquals($state, $this->contract->getState());
    }

    /**
     * @Given /^l\'avenant est "([^"]*)"\.$/
     */
    public function lavenantEst($state)
    {
        if ($state === 'canceled') {
            $this->amendment->setCanceledAt(Carbon::now());
        }
        if ($state === 'inactive') {
            $this->amendment->setInactiveAt(Carbon::now());
        }
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
        self::assertEquals($state, $this->amendment->getState());
    }

    /**
     * @Given /^l\'avenant n\'est pas prêt à être signé sur yousign$/
     */
    public function lavenantNestPasPretAEtreSigneSurYousign()
    {
        self::assertNull($this->contract->getYousignProcedureId());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^l\'avenant est prêt à être signé sur yousign$/
     */
    public function lavenantEstPretAEtreSigneSurYousign()
    {
        $this->amendment->setYousignProcedureId('yousign_procedure_id');
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertNotNull($this->amendment->getYousignProcedureId());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^le contrat est prêt à être signé sur yousign$/
     */
    public function leContratEstPretAEtreSigneSurYousign()
    {
        $this->contract->setYousignProcedureId('yousign_procedure_id');
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertNotNull($this->contract->getYousignProcedureId());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de début du contrat est supérieur à la date du jour$/
     */
    public function laDateDeDebutDuContratEstSuperieurALaDateDuJour()
    {
        $this->contract->setValidFrom(Carbon::now()->addWeek());
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertTrue($this->contract->getValidFrom()->isFuture());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de fin du contrat est supérieur à la date du jour$/
     */
    public function laDateDeFinDuContratEstSuperieurALaDateDuJour()
    {
        $this->contract->setValidUntil(Carbon::now()->addWeek());
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertTrue($this->contract->getValidUntil()->isFuture());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de fin du contrat est inférieur ou égale à la date du jour$/
     */
    public function laDateDeFinDuContratEstInferieurOuEgaleALaDateDuJour()
    {
        $this->contract->setValidUntil(Carbon::now()->subWeek());
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertTrue($this->contract->getValidUntil()->isPast());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de début du contrat est inférieur ou égale à la date du jour$/
     */
    public function laDateDeDebutDuContratEstInferieurALaDateDuJour()
    {
        $this->contract->setValidFrom(Carbon::now()->subWeek());
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertTrue($this->contract->getValidFrom()->isPast());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de fin du contrat n\'est pas définie$/
     */
    public function laDateDeFinDuContratNestPasDefinie()
    {
        $this->contract->setValidUntil(null);
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertNull($this->contract->getValidUntil());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date de début du contrat n\'est pas définie$/
     */
    public function laDateDeDebutDuContratNestPasDefinie()
    {
        $this->contract->setValidFrom(null);
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertNull($this->contract->getValidFrom());
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date du jour est comprise entre la date de début et la date de fin du contrat$/
     */
    public function laDateDuJourEstCompriseEntreLaDateDeDebutEtLaDateDeFinDuContrat()
    {
        $this->contract->setValidFrom(Carbon::now()->subWeek());
        $this->contract->setValidUntil(Carbon::now()->addWeek());
        $this->contract = $this->contractRepository->save($this->contract);
        self::assertTrue(Carbon::now()->isBetween($this->contract->getValidFrom(), $this->contract->getValidUntil()));
        $this->contract = $this->contractStateRepository->updateContractState($this->contract);
    }

    /**
     * @Given /^la date du jour est comprise entre la date de début et la date de fin de l\'avenant$/
     */
    public function laDateDuJourEstCompriseEntreLaDateDeDebutEtLaDateDeFinDeLavenant()
    {
        $this->amendment->setValidFrom(Carbon::now()->subWeek());
        $this->amendment->setValidUntil(Carbon::now()->addWeek());
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertTrue(Carbon::now()->isBetween($this->amendment->getValidFrom(), $this->amendment->getValidUntil()));
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de début de l\'avenant est supérieur à la date du jour$/
     */
    public function laDateDeDebutDeLavenantEstSuperieurALaDateDuJour()
    {
        $this->amendment->setValidFrom(Carbon::now()->addWeek());
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertTrue($this->amendment->getValidFrom()->isFuture());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de fin de l\'avenant est inférieur ou égale à la date du jour$/
     */
    public function laDateDeFinDeLavenantEstInferieurOuEgaleALaDateDuJour()
    {
        $this->amendment->setValidUntil(Carbon::now()->subWeek());
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertTrue($this->amendment->getValidUntil()->isPast());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de fin de l\'avenant est supérieur à la date du jour$/
     */
    public function laDateDeFinDeLavenantEstSuperieurALaDateDuJour()
    {
        $this->amendment->setValidUntil(Carbon::now()->addWeek());
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertTrue($this->amendment->getValidUntil()->isFuture());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de fin de l\'avenant n\'est pas définie$/
     */
    public function laDateDeFinDeLavenantNestPasDefinie()
    {
        $this->amendment->setValidUntil(null);
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertNull($this->amendment->getValidUntil());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de début de l\'avenant n\'est pas définie$/
     */
    public function laDateDeDebutDeLavenantNestPasDefinie()
    {
        $this->amendment->setValidFrom(null);
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertNull($this->amendment->getValidFrom());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }

    /**
     * @Given /^la date de début de l\'avenant est inférieur ou égale à la date du jour$/
     */
    public function laDateDeDebutDeLavenantEstInferieurOuEgaleALaDateDuJour()
    {
        $this->amendment->setValidFrom(Carbon::now()->subWeek());
        $this->amendment = $this->contractRepository->save($this->amendment);
        self::assertTrue($this->amendment->getValidFrom()->isPast());
        $this->amendment = $this->contractStateRepository->updateContractState($this->amendment);
    }
}
