<?php

namespace App\Models\Addworking\Contract;

use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Contract\ContractRepository;
use App\Repositories\Addworking\Contract\ContractTemplateRepository;
use App\Repositories\SigningHub\Contract\ContractRepository as SigningHubContractRepository;
use Components\Infrastructure\Foundation\Application\Deprecated;

trait ContractCompat
{
    use Deprecated;

    /**
     * @deprecated v0.53.5 replaced by SigningHubContractRepository::getContractFromSigningHubPackage
     */
    public static function fromSigningHubPackage($id): Contract
    {
        self::deprecated(__METHOD__, "SigningHubContractRepository::getContractFromSigningHubPackage");

        return app(SigningHubContractRepository::class)->getContractFromSigningHubPackage($id);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractTemplateRepository::getAvailableTemplatesForContract
     */
    public function getAvailableTemplates()
    {
        self::deprecated(__METHOD__, "ContractTemplateRepository::getAvailableTemplatesForContract");

        return app(ContractTemplateRepository::class)->getAvailableTemplatesForContract($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::log
     */
    public function log(string $message, array $data = []): Contract
    {
        self::deprecated(__METHOD__, "ContractRepository::log");

        return app(ContractRepository::class)->log($this, $message, $data);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::nextSignatoryIs
     */
    public function nextSignatoryIs(User $user): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::nextSignatoryIs");

        return app(ContractRepository::class)->nextSignatoryIs($this, $user);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isSignedBy
     */
    public function isSignedBy(User $user): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isSignedBy");

        return app(ContractRepository::class)->isSignedBy($this, $user);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::signatories
     */
    public function signatories()
    {
        self::deprecated(__METHOD__, "ContractRepository::signatories");

        return app(ContractRepository::class)->signatories($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isDraft
     */
    public function isDraft(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isDraft");

        return app(ContractRepository::class)->isDraft($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isReadyToGenerate
     */
    public function isReadyToGenerate(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isReadyToGenerate");

        return app(ContractRepository::class)->isReadyToGenerate($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isGenerating
     */
    public function isGenerating(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isGenerating");

        return app(ContractRepository::class)->isGenerating($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isGenerated
     */
    public function isGenerated(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isGenerated");

        return app(ContractRepository::class)->isGenerated($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isUploading
     */
    public function isUploading(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isUploading");

        return app(ContractRepository::class)->isUploading($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isUploaded
     */
    public function isUploaded(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isUploaded");

        return app(ContractRepository::class)->isUploaded($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isReadyToSign
     */
    public function isReadyToSign(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isReadyToSign");

        return app(ContractRepository::class)->isReadyToSign($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isBeingSigned
     */
    public function isBeingSigned(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isBeingSigned");

        return app(ContractRepository::class)->isBeingSigned($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isCancelled
     */
    public function isCancelled(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isCancelled");

        return app(ContractRepository::class)->isCancelled($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isActive
     */
    public function isActive(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isActive");

        return app(ContractRepository::class)->isActive($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isInactive
     */
    public function isInactive(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isInactive");

        return app(ContractRepository::class)->isInactive($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isExpired
     */
    public function isExpired(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isExpired");

        return app(ContractRepository::class)->isExpired($this);
    }

    /**
     * @deprecated v0.53.5 replaced by ContractRepository::isError
     */
    public function isError(): bool
    {
        self::deprecated(__METHOD__, "ContractRepository::isError");

        return app(ContractRepository::class)->isError($this);
    }
}
