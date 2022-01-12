<?php

namespace Components\Enterprise\Enterprise\Tests\Acceptance\CheckCompliance;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Repositories\Addworking\Enterprise\DocumentTypeRepository;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\Exceptions\EnterpriseNotFoundException;
use Components\Enterprise\Enterprise\Domain\Exceptions\VendorHasNoActivityWithThisCustomerException;
use Components\Enterprise\Enterprise\Domain\Exceptions\VendorHasNoPartnershipWithTheCustomerException;
use Components\Enterprise\Enterprise\Domain\Exceptions\VendorIsNotCompliantException;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckComplianceContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;
    private $customer;
    private $vendor;

    private $documentTypeRepository;
    private $enterpriseRepository;
    private $legalFormRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->documentTypeRepository = new DocumentTypeRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->legalFormRepository = new LegalFormRepository;
        $this->userRepository = new UserRepository;
    }

    /**
     * @Given /^les formes légales suivantes existent$/
     */
    public function lesFormesLegalesSuivantesExistent(TableNode $legal_forms)
    {
        foreach ($legal_forms as $item) {
            LegalForm::make([
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'country' => $item['country'],
            ])->save();
        }
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises  as $item) {
            $enterprise = $this->enterpriseRepository->make([
                'identification_number' => $item['siret'],
                'name' => $item['name'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor']
            ]);

            $legal_form = $this->legalFormRepository->findByName($item['legal_form_name']);
            $enterprise->legalForm()->associate($legal_form)->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());
        }
    }

    /**
     * @Given /^les partenariats suivants existent$/
     */
    public function lesPartenariatsSuivantsExistent(TableNode $partnerships)
    {
        foreach ($partnerships as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['customer_siret']);
            $vendor = $this->enterpriseRepository->findBySiret($item['vendor_siret']);

            $customer->vendors()->attach($vendor, [
                'activity_starts_at' => $item['activity_starts_at'] === 'null' ? null : $item['activity_starts_at']
            ]);
        }
    }

    /**
     * @Given /^les documents types suivants existent$/
     */
    public function lesDocumentsTypesSuivantsExistent(TableNode $document_types)
    {
        foreach ($document_types as $item) {
            $document_type = factory(DocumentType::class)->make([
                'display_name' => $item['display_name'],
                'name' => $item['name'],
                'type' => $item['type'],
                'code' => $item['code'],
                'is_mandatory' => $item['is_mandatory'],
                'validity_period' => $item['validity_period']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $document_type->enterprise()->associate($enterprise)->save();

            $legal_form = $this->legalFormRepository->findByName($item['legal_form_name']);
            $document_type->legalForms()->attach($legal_form);
        }
    }

    /**
     * @Given /^les documents suivants existent$/
     */
    public function lesDocumentsSuivantsExistent(TableNode $documents)
    {
        foreach ($documents as $item) {
            $valid_until = Str::camel($item['valid_until']);
            $rejected_at = Str::camel($item['rejected_at']);
            $document = factory(Document::class)->make([
                'status' => $item['status'],
                'valid_from' => $item['valid_from'],
                'valid_until' => Carbon::today()->{$valid_until}(),
                'rejected_at' => $item['rejected_at'] === 'null' ? null : Carbon::today()->{$rejected_at}(),
            ]);

            $document_type = $this->documentTypeRepository->findByNameAndEnterprise(
                $item['document_type_name'],
                $this->enterpriseRepository->findBySiret($item['document_type_siret'])
            );

            $enterprise = $this->enterpriseRepository->findBySiret($item['vendor_siret']);

            $document
                ->documentType()->associate($document_type)
                ->enterprise()->associate($enterprise)
                ->save();
        }
    }

    /**
     * @Given /^l\'entreprise de type "([^"]*)" avec le siret "([^"]*)" existe$/
     */
    public function lentrepriseDeTypeAvecLeSiretExiste($enterprise_type, $enterprise_siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($enterprise_siret);

        self::assertNotNull($enterprise);

        switch($enterprise_type) {
            case "customer":
                $this->customer = $enterprise;
                self::assertTrue($enterprise->is_customer);
                break;
            case "vendor":
                $this->vendor = $enterprise;
                self::assertTrue($enterprise->is_vendor);
                break;
        }
    }

    /**
     * @Given /^les deux entreprises sont partenaires$/
     */
    public function lesDeuxEntreprisesSontPartenaires()
    {
        self::assertTrue($this->customer->vendors->contains($this->vendor));
    }

    /**
     * @Given /^les deux entreprises ne sont pas partenaires$/
     */
    public function lesDeuxEntreprisesNeSontPasPartenaires()
    {
        self::assertFalse($this->customer->vendors->contains($this->vendor));
    }

    /**
     * @Given /^les deux entreprises sont en activité$/
     */
    public function lesDeuxEntreprisesSontEnActivite()
    {
        self::assertTrue($this->vendor->vendorInActivityWithCustomer($this->customer));
    }

    /**
     * @Given /^les deux entreprises ne sont pas en activité$/
     */
    public function lesDeuxEntreprisesNeSontPasEnActivite()
    {
        self::assertFalse($this->vendor->vendorInActivityWithCustomer($this->customer));
    }

    /**
     * @When /^j\'essaie de vérifier la conformité du prestataire par rapport au client$/
     */
    public function jessaieDeVerifierLaConformiteDuPrestataireParRapportAuClient()
    {
        try {
            $this->response = false;

            $this->checkEnterprise($this->customer);
            $this->checkEnterprise($this->vendor);

            $this->checkPartnership($this->customer, $this->vendor);
            $this->checkPartnershipActivity($this->customer, $this->vendor);

            $this->checkCompliance($this->vendor, $this->customer);

            $this->response = true;

        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    private function checkEnterprise(Enterprise $enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseNotFoundException;
        }
    }

    private function checkPartnership(Enterprise $customer, Enterprise $vendor)
    {
        if (! $this->enterpriseRepository->checkPartnership($customer, $vendor)) {
            throw new VendorHasNoPartnershipWithTheCustomerException;
        }
    }

    private function checkPartnershipActivity(Enterprise $customer, Enterprise $vendor)
    {
        if (! $this->enterpriseRepository->checkPartnershipActivity($customer, $vendor)) {
            throw new VendorHasNoActivityWithThisCustomerException;
        }
    }

    private function checkCompliance($vendor, $customer)
    {
        if (! $this->enterpriseRepository->isCompliantFor($vendor, $customer)) {
            throw new VendorIsNotCompliantException;
        }
    }

    /**
     * @Then /^le prestataire n\'est pas inclus dans la liste des prestataires non conformes de ce client$/
     */
    public function lePrestataireNestPasInclusDansLaListeDesPrestatairesNonConformesDeCeClient()
    {
        $this->assertTrue($this->response);
    }

    /**
     * @Then /^le prestataire est inclus dans la liste des prestataires non conformes de ce client$/
     */
    public function lePrestataireEstInclusDansLaListeDesPrestatairesNonConformesDeCeClient()
    {
        $this->assertFalse($this->response);
    }

    /**
     * @Then /^une erreur est levée car le prestataire n\'est pas actif pour le client$/
     */
    public function uneErreurEstLeveeCarLePrestataireNestPasActifPourLeClient()
    {
        self::assertContainsEquals(
            VendorHasNoActivityWithThisCustomerException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le prestataire n\'est pas en partenariat avec le client$/
     */
    public function uneErreurEstLeveeCarLePrestataireNestPasEnPartenariatAvecLeClient()
    {
        self::assertContainsEquals(
            VendorHasNoPartnershipWithTheCustomerException::class,
            $this->errors
        );
    }
}
