<?php

namespace App\Models\Addworking\Enterprise;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Mission\Offer;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\BillingEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\ComplianceEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\CustomerRepository;
use App\Repositories\Addworking\Enterprise\DocumentRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseActivityRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseAddressRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseContractRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseDepartmentRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseIbanRepository;
use App\Repositories\Addworking\Enterprise\EnterprisePhoneNumberRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\VendorRepository;
use App\Repositories\CoursierFr\Enterprise\CoursierFrEnterpriseRepository;
use App\Repositories\Edenred\Enterprise\EdenredEnterpriseRepository;
use App\Repositories\Edenred\Enterprise\MissionRatesEnterpriseRepository;
use App\Repositories\Everial\Enterprise\EverialEnterpriseRepository;
use App\Repositories\GcsEurope\Enterprise\GcsEuropeEnterpriseRepository;
use App\Repositories\Sogetrel\Enterprise\PassworkEnterpriseRepository;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use App\Repositories\TseExpressMedical\Enterprise\TseExpressMedicalEnterpriseRepository;
use Components\Infrastructure\Foundation\Application\Deprecated;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;

trait EnterpriseCompat
{
    use Deprecated;

    /**
     * @deprecated v0.51.1 replaced by AddworkingEnterpriseRepository::getAddworkingEnterprise
     */
    public static function addworking(): self
    {
        self::deprecated(__METHOD__, "AddworkingEnterpriseRepository::getAddworkingEnterprise");

        return app(AddworkingEnterpriseRepository::class)->getAddworkingEnterprise();
    }

    /**
     * @deprecated v0.51.1 replaced by ComplianceEnterpriseRepository::getComplianceManagers
     */
    public function complianceManagers(): Relation
    {
        self::deprecated(__METHOD__, "ComplianceEnterpriseRepository::getCustomerComplianceManagers");

        return app(ComplianceEnterpriseRepository::class)->getCustomerComplianceManagers($this);
    }

    /**
     * @deprecated v0.51.1 replaced by PassworkEnterpriseRepository::hasSogetrelPasswork
     */
    public function hasSogetrelPasswork(): bool
    {
        self::deprecated(__METHOD__, "PassworkEnterpriseRepository::hasSogetrelPasswork");

        return app(PassworkEnterpriseRepository::class)->hasSogetrelPasswork($this);
    }

    /**
     * @deprecated v0.51.1 replaced by EnterpriseRepository::sanitizeName
     */
    public static function sanitizeName(string $value): string
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::sanitizeName");

        return app(EnterpriseRepository::class)->sanitizeName($value);
    }

    /**
     * @deprecated v0.51.1 replaced by VendorRepository::getAvailableVendors
     */
    public static function getAvailableVendors(): Collection
    {
        self::deprecated(__METHOD__, "VendorRepository::getAvailableVendors");

        return app(VendorRepository::class)->getAvailableVendors();
    }

    /**
     * @deprecated v0.51.1 replaced by MissionRatesEnterpriseRepository::hasRateForOffer
     */
    public function hasRateForOffer(Offer $offer): bool
    {
        self::deprecated(__METHOD__, "MissionRatesEnterpriseRepository::hasRateForOffer");

        return app(MissionRatesEnterpriseRepository::class)->hasRateForOffer($this, $offer);
    }

    /**
     * @deprecated v0.51.3 replaced by BillingEnterpriseRepository::isUnderTrial
     */
    public function isUnderTrial($date = null): bool
    {
        self::deprecated(__METHOD__, "BillingEnterpriseRepository::isUnderTrial");

        return app(BillingEnterpriseRepository::class)->isUnderTrial($this, $date);
    }

    /**
     * @deprecated v0.51.3 replaced by VendorRepository::isVendor
     */
    public function isVendor(): bool
    {
        self::deprecated(__METHOD__, "VendorRepository::isVendor");

        return app(VendorRepository::class)->isVendor($this);
    }

    /**
     * @deprecated v0.51.3 replaced by CustomerRepository::isCustomer
     */
    public function isCustomer(): bool
    {
        self::deprecated(__METHOD__, "CustomerRepository::isCustomer");

        return app(CustomerRepository::class)->isCustomer($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseRepository::fromIdentificationNumber
     */
    public static function fromIdentificationNumber(string $number): Enterprise
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::fromIdentificationNumber");

        return app(EnterpriseRepository::class)->fromIdentificationNumber($number);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseRepository::fromName
     */
    public static function fromName(string $name): Enterprise
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::fromName");

        return app(EnterpriseRepository::class)->fromName($name);
    }

    /**
     * @deprecated v0.51.3 replaced by PassworkEnterpriseRepository::hasTagSoconnext
     */
    public function hasTagSoconnext(): bool
    {
        self::deprecated(__METHOD__, "PassworkEnterpriseRepository::hasTagSoconnext");

        return app(PassworkEnterpriseRepository::class)->hasTagSoconnext($this);
    }

    /**
     * @deprecated v0.51.3 replaced by FamilyEnterpriseRepository::getAllCustomersAndAncestors
     */
    public function getAllCustomersAndAncestors(): EloquentCollection
    {
        self::deprecated(__METHOD__, "FamilyEnterpriseRepository::getAllCustomersAndAncestors");

        return app(FamilyEnterpriseRepository::class)->getAllCustomersAndAncestors($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseAddressRepository::getFirstAddress
     */
    public function getFirstAddressAttribute(): string
    {
        self::deprecated(__METHOD__, "EnterpriseAddressRepository::getFirstAddress");

        return app(EnterpriseAddressRepository::class)->getFirstAddress($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseAddressRepository::getAddress
     */
    public function getAddressAttribute(): Address
    {
        self::deprecated(__METHOD__, "EnterpriseAddressRepository::getAddress");

        return app(EnterpriseAddressRepository::class)->getAddress($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterprisePhoneNumberRepository::getPrimaryPhoneNumber
     */
    public function getPrimaryPhoneNumberAttribute(): string
    {
        self::deprecated(__METHOD__, "EnterprisePhoneNumberRepository::getPrimaryPhoneNumber");

        return app(EnterprisePhoneNumberRepository::class)->getPrimaryPhoneNumber($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterprisePhoneNumberRepository::getSecondaryPhoneNumber
     */
    public function getSecondaryPhoneNumberAttribute(): string
    {
        self::deprecated(__METHOD__, "EnterprisePhoneNumberRepository::getSecondaryPhoneNumber");

        return app(EnterprisePhoneNumberRepository::class)->getSecondaryPhoneNumber($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseActivityRepository::getActivityOf
     */
    public function getActivityAttribute(): EnterpriseActivity
    {
        self::deprecated(__METHOD__, "EnterpriseActivityRepository::getActivityOf");

        return app(EnterpriseActivityRepository::class)->getActivityOf($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseDepartmentRepository::getDepartmentsOf
     */
    public function getDepartmentsAttribute(): EloquentCollection
    {
        self::deprecated(__METHOD__, "EnterpriseDepartmentRepository::getDepartmentsOf");

        return app(EnterpriseDepartmentRepository::class)->getDepartmentsOf($this);
    }

    /**
     * @deprecated v0.51.3 replaced by AddworkingEnterpriseRepository::isAddworking
     */
    public function isAddworking(): bool
    {
        self::deprecated(__METHOD__, "AddworkingEnterpriseRepository::isAddworking");

        return app(AddworkingEnterpriseRepository::class)->isAddworking($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EdenredEnterpriseRepository::isEdenred
     */
    public function isEdenred(): bool
    {
        self::deprecated(__METHOD__, "EdenredEnterpriseRepository::isEdenred");

        return app(EdenredEnterpriseRepository::class)->isEdenred($this);
    }

    /**
     * @deprecated v0.51.3 replaced by SogetrelEnterpriseRepository::isSogetrel
     */
    public function isSogetrel(): bool
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isSogetrel");

        return app(SogetrelEnterpriseRepository::class)->isSogetrel($this);
    }

    /**
     * @deprecated v0.51.3 replaced by SogetrelEnterpriseRepository::isSubsidiaryOfSogetrel
     */
    public function isSogetrelOrSubsidiary(): bool
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isSubsidiaryOfSogetrel");

        return app(SogetrelEnterpriseRepository::class)->isSubsidiaryOfSogetrel($this);
    }

    /**
     * @deprecated v0.51.3 replaced by CoursierFrEnterpriseRepository::isCoursierFr
     */
    public function isCoursierFr(): bool
    {
        self::deprecated(__METHOD__, "CoursierFrEnterpriseRepository::isCoursierFr");

        return app(CoursierFrEnterpriseRepository::class)->isCoursierFr($this);
    }

    /**
     * @deprecated v0.51.3 replaced by TseExpressMedicalEnterpriseRepository::isTseExpressMedical
     */
    public function isTseExpressMedical(): bool
    {
        self::deprecated(__METHOD__, "TseExpressMedicalEnterpriseRepository::isTseExpressMedical");

        return app(TseExpressMedicalEnterpriseRepository::class)->isTseExpressMedical($this);
    }

    /**
     * @deprecated v0.51.3 replaced by GcsEuropeEnterpriseRepository::isGcsEurope
     */
    public function isGcsEurope(): bool
    {
        self::deprecated(__METHOD__, "GcsEuropeEnterpriseRepository::isGcsEurope");

        return app(GcsEuropeEnterpriseRepository::class)->isGcsEurope($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EverialEnterpriseRepository::isEverial
     */
    public function isEverial(): bool
    {
        self::deprecated(__METHOD__, "EverialEnterpriseRepository::isEverial");

        return app(EverialEnterpriseRepository::class)->isEverial($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterprisePhoneNumberRepository::getPhoneNumber
     */
    public function getPhoneNumberAttribute(): PhoneNumber
    {
        self::deprecated(__METHOD__, "EnterprisePhoneNumberRepository::getPhoneNumber");

        return app(EnterprisePhoneNumberRepository::class)->getPhoneNumber($this);
    }

    /**
     * @deprecated v0.51.3 replaced by FamilyEnterpriseRepository::getDescendants
     */
    public function descendants(bool $include_self = false): Collection
    {
        self::deprecated(__METHOD__, "FamilyEnterpriseRepository::getDescendants");

        return app(FamilyEnterpriseRepository::class)->getDescendants($this, $include_self);
    }

    /**
     * @deprecated v0.51.3 replaced by FamilyEnterpriseRepository::getAncestors
     */
    public function ancestors(bool $include_self = false): Collection
    {
        self::deprecated(__METHOD__, "FamilyEnterpriseRepository::getAncestors");

        return app(FamilyEnterpriseRepository::class)->getAncestors($this, $include_self);
    }

    /**
     * @deprecated v0.51.3 replaced by FamilyEnterpriseRepository::getFamily
     */
    public function family(): Collection
    {
        self::deprecated(__METHOD__, "FamilyEnterpriseRepository::getFamily");

        return app(FamilyEnterpriseRepository::class)->getFamily($this);
    }

    /**
     * @deprecated v0.51.3 replaced by FamilyEnterpriseRepository::areFromSameFamily
     */
    public function isMemberOfFamily(Enterprise $enterprise): bool
    {
        self::deprecated(__METHOD__, "FamilyEnterpriseRepository::areFromSameFamily");

        return app(FamilyEnterpriseRepository::class)->areFromSameFamily($this, $enterprise);
    }

    /**
     * @deprecated v0.51.3 replaced by CustomerRepository::isCustomerOf
     */
    public function isCustomerOf(Enterprise $vendor): bool
    {
        self::deprecated(__METHOD__, "CustomerRepository::isCustomerOf");

        return app(CustomerRepository::class)->isCustomerOf($this, $vendor);
    }

    /**
     * @deprecated v0.51.3 replaced by VendorRepository::isVendorOf
     */
    public function isVendorOf(Enterprise $customer): bool
    {
        self::deprecated(__METHOD__, "VendorRepository::isVendorOf");

        return app(VendorRepository::class)->isVendorOf($this, $customer);
    }

    /**
     * @deprecated v0.51.3 replaced by CustomerRepository::hasCustomers
     */
    public function hasCustomers(): bool
    {
        self::deprecated(__METHOD__, "CustomerRepository::hasCustomers");

        return app(CustomerRepository::class)->hasCustomers($this);
    }

    /**
     * @deprecated v0.51.3 replaced by VendorRepository::hasVendors
     */
    public function hasVendors(): bool
    {
        self::deprecated(__METHOD__, "VendorRepository::hasVendors");

        return app(VendorRepository::class)->hasVendors($this);
    }

    /**
     * @deprecated v0.51.3 replaced by SogetrelEnterpriseRepository::isVendorOfSogetrelSubsidiaries
     */
    public function isVendorOfSogetrelSubsidiaries(): bool
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isVendorOfSogetrelSubsidiaries");

        return app(SogetrelEnterpriseRepository::class)->isVendorOfSogetrelSubsidiaries($this);
    }

    /**
     * @deprecated v0.51.3 replaced by SogetrelEnterpriseRepository::isMemberOfSogetrelGroup
     */
    public function isMemberOfSogetrelGroup()
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isMemberOfSogetrelGroup");

        return app(SogetrelEnterpriseRepository::class)->isMemberOfSogetrelGroup($this);
    }

    /**
     * @deprecated v0.51.3 replaced by SogetrelEnterpriseRepository::isVendorOfSogetrel
     */
    public function isVendorOfSogetrel(): bool
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isVendorOfSogetrel");

        return app(SogetrelEnterpriseRepository::class)->isVendorOfSogetrel($this);
    }

    /**
     * @deprecated v0.51.3 replaced by DocumentRepository::isReadyToWorkFor
     */
    public function isReadyToWorkFor(Enterprise $customer, string $document_type = null): bool
    {
        self::deprecated(__METHOD__, "DocumentRepository::isReadyToWorkFor");

        return app(DocumentRepository::class)->isReadyToWorkFor($this, $customer, $document_type);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseIbanRepository::getIban
     */
    public function getIbanAttribute(): Iban
    {
        self::deprecated(__METHOD__, "EnterpriseIbanRepository::getIban");

        return app(EnterpriseIbanRepository::class)->getIban($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseContractRepository::hasSignedContracts
     */
    public function hasSignedContracts(string $type): bool
    {
        self::deprecated(__METHOD__, "EnterpriseContractRepository::hasSignedContracts");

        return app(EnterpriseContractRepository::class)->hasSignedContracts($this, $type);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseContractRepository::hasCps1
     */
    public function hasCps1()
    {
        self::deprecated(__METHOD__, "EnterpriseContractRepository::hasCps1");

        return app(EnterpriseContractRepository::class)->hasCps1($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseContractRepository::hasCps2
     */
    public function hasCps2()
    {
        self::deprecated(__METHOD__, "EnterpriseContractRepository::hasCps2");

        return app(EnterpriseContractRepository::class)->hasCps2($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseContractRepository::hasCps3
     */
    public function hasCps3()
    {
        self::deprecated(__METHOD__, "EnterpriseContractRepository::hasCps3");

        return app(EnterpriseContractRepository::class)->hasCps3($this);
    }

    /**
     * @deprecated v0.51.3 replaced by EnterpriseActivityRepository::getEmployeesCount
     */
    public function getEmployeesCountAttribute()
    {
        self::deprecated(__METHOD__, "EnterpriseActivityRepository::getEmployeesCount");

        return app(EnterpriseActivityRepository::class)->getEmployeesCount($this);
    }

    /**
     * @deprecated v0.51.1 replaced by PassworkEnterpriseRepository::passworks
     */
    public function sogetrelPassworks(): EloquentCollection
    {
        self::deprecated(__METHOD__, "PassworkEnterpriseRepository::sogetrelPasswork");

        return app(PassworkEnterpriseRepository::class)->passworks($this);
    }

    /**
     * @deprecated v0.57.1 replaced by EnterpriseRepository::isPartOf
     */
    public function isPartOfDomain(Enterprise $customer): bool
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::isPartOfDomain");

        return app(EnterpriseRepository::class)->isPartOfDomain($this, $customer);
    }

    /**
     * @deprecated v0.57.1 replaced by EdenredEnterpriseRepository::isPartOfEdenred
     */
    public function isPartOfEdenredDomain(): bool
    {
        self::deprecated(__METHOD__, "EdenredEnterpriseRepository::isPartOfEdenredDomain");

        return app(EdenredEnterpriseRepository::class)->isPartOfEdenredDomain($this);
    }

    /**
     * @deprecated v0.57.1 replaced by SogetrelEnterpriseRepository::isPartOfSogetrel
     */
    public function isPartOfSogetrelDomain(): bool
    {
        self::deprecated(__METHOD__, "SogetrelEnterpriseRepository::isPartOfSogetrelDomain");

        return app(SogetrelEnterpriseRepository::class)->isPartOfSogetrelDomain($this);
    }

    /**
     * @deprecated v0.57.1 replaced by EverialEnterpriseRepository::isPartOfEverial
     */
    public function isPartOfEverialDomain(): bool
    {
        self::deprecated(__METHOD__, "EverialEnterpriseRepository::isPartOfEverialDomain");

        return app(EverialEnterpriseRepository::class)->isPartOfEverialDomain($this);
    }

    /**
     * @deprecated v0.57.1 replaced by EnterpriseRepository::isPartOfApp
     */
    public function isPartOfAppDomain(): bool
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::isPartOfAppDomain");

        return app(EnterpriseRepository::class)->isPartOfAppDomain($this);
    }


    /**
     * @deprecated v0.57.5 replaced by EnterpriseRepository::hasFinishedOnboardingProcess
     */
    public function hasFinishedOnboardingProcess(): bool
    {
        self::deprecated(__METHOD__, "EnterpriseRepository::hasFinishedOnboardingProcess");

        return app(EnterpriseRepository::class)->hasFinishedOnboardingProcess($this);
    }
}
