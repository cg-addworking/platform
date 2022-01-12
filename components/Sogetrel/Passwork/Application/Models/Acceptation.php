<?php

namespace Components\Sogetrel\Passwork\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use Components\Sogetrel\Passwork\Application\Models\Scopes\SearchScope;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationEntityInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acceptation extends Model implements AcceptationEntityInterface
{
    use HasUuid, SoftDeletes, SearchScope ;

    protected $table = "sogetrel_user_passwork_acceptations";

    protected $fillable = [
        'number',
        'operational_manager_name',
        'administrative_assistant_name',
        'administrative_manager_name',
        'contract_signatory_name',
        'needs_decennial_insurance',
        'applicable_price_schedule',
        'bank_guarantee_amount',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'contract_starting_at' => 'datetime',
        'contract_ending_at' => 'datetime',
        'needs_decennial_insurance' => 'boolean',
    ];

    protected $attributes = [
        'needs_decennial_insurance' => false,
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function sogetrelPasswork()
    {
        return $this->belongsTo(SogetrelPasswork::class, 'passwork_id')->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function acceptationContractTypes()
    {
        return $this->hasMany(AcceptationContractType::class, 'passwork_acceptation_id');
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by')->withDefault();
    }

    public function operationalManager()
    {
        return $this->belongsTo(User::class, 'operational_manager')->withDefault();
    }

    public function administrativeAssistant()
    {
        return $this->belongsTo(User::class, 'administrative_assistant')->withDefault();
    }

    public function administrativeManager()
    {
        return $this->belongsTo(User::class, 'administrative_manager')->withDefault();
    }

    public function contractSignatory()
    {
        return $this->belongsTo(User::class, 'contract_signatory')->withDefault();
    }

    public function acceptationComment()
    {
        return $this->belongsTo(Comment::class, 'acceptation_comment')->withDefault();
    }

    public function operationalMonitoringDataComment()
    {
        return $this->belongsTo(Comment::class, 'operational_monitoring_data_comment')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setSogetrelPasswork(SogetrelPasswork $passwork): void
    {
        $this->sogetrelPasswork()->associate($passwork);
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setContractStartingAt(DateTime $contract_starting_at): void
    {
        $this->contract_starting_at = $contract_starting_at;
    }

    public function setContractEndingAt(DateTime $contract_ending_at): void
    {
        $this->contract_ending_at = $contract_ending_at;
    }

    public function setAcceptedBy(User $accepted_by): void
    {
        $this->acceptedBy()->associate($accepted_by);
    }

    public function setAcceptedByName(string $accepted_by_name): void
    {
        $this->accepted_by_name = $accepted_by_name;
    }

    public function setOperationalManager(User $operational_manager): void
    {
        $this->operationalManager()->associate($operational_manager);
    }

    public function setOperationalManagerName(string $operational_manager_name): void
    {
        $this->operational_manager_name = $operational_manager_name;
    }

    public function setAdministrativeAssistant(User $administrative_assistant): void
    {
        $this->administrativeAssistant()->associate($administrative_assistant);
    }

    public function setAdministrativeAssistantName(string $administrative_assistant_name): void
    {
        $this->administrative_assistant_name = $administrative_assistant_name;
    }

    public function setAdministrativeManager(User $administrative_manager): void
    {
        $this->administrativeManager()->associate($administrative_manager);
    }

    public function setAdministrativeManagerName(string $administrative_manager_name): void
    {
        $this->administrative_manager_name = $administrative_manager_name;
    }

    public function setContractSignatory(User $contract_signatory): void
    {
        $this->contractSignatory()->associate($contract_signatory);
    }

    public function setContractSignatoryName(string $contract_signatory_name): void
    {
        $this->contract_signatory_name = $contract_signatory_name;
    }

    public function setAcceptationComment(?Comment $comment): void
    {
        $this->acceptationComment()->associate($comment);
    }

    public function setOperationalMonitoringDataComment(Comment $comment): void
    {
        $this->operationalMonitoringDataComment()->associate($comment);
    }

    public function setNeedsDecennialInsurance(bool $needs_decennial_insurance): void
    {
        $this->needs_decennial_insurance = $needs_decennial_insurance;
    }

    public function setApplicablePriceSlip(string $applicable_price_slip): void
    {
        $this->applicable_price_slip = $applicable_price_slip;
    }

    public function setBankGuaranteeAmount(?float $bank_guarantee_amount): void
    {
        $this->bank_guarantee_amount = $bank_guarantee_amount;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getSogetrelPasswork(): SogetrelPasswork
    {
        return $this->sogetrelPasswork()->get()->first();
    }

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise()->get()->first();
    }

    public function getAcceptedBy(): ?User
    {
        return $this->acceptedBy()->get()->first();
    }

    public function getAcceptedByName(): string
    {
        return $this->accepted_by_name;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function getOperationalManager(): ?User
    {
        return $this->operationalManager()->get()->first();
    }

    public function getOperationalManagerName(): string
    {
        return $this->operational_manager_name;
    }

    public function getAdministrativeAssistant(): ?User
    {
        return $this->administrativeAssistant()->get()->first();
    }

    public function getAdministrativeAssistantName(): string
    {
        return $this->administrative_assistant_name;
    }

    public function getAdministrativeManager(): ?User
    {
        return $this->administrativeManager()->get()->first();
    }

    public function getAdministrativeManagerName(): string
    {
        return $this->administrative_manager_name;
    }

    public function getContractSignatory(): ?User
    {
        return $this->contractSignatory()->get()->first();
    }

    public function getContractSignatoryName(): string
    {
        return $this->contract_signatory_name;
    }

    public function getNeedsDecennialInsurance(): bool
    {
        return $this->needs_decennial_insurance;
    }

    public function getApplicablePriceSlip(): string
    {
        return $this->applicable_price_slip;
    }

    public function getBankGuaranteeAmount(): ?float
    {
        return $this->bank_guarantee_amount;
    }

    public function getContractStartingAt(): ?DateTime
    {
        return $this->contract_starting_at;
    }

    public function getContractEndingAt(): ?DateTime
    {
        return $this->contract_ending_at;
    }

    public function getAcceptationComment(): ?Comment
    {
        return $this->acceptationComment()->withTrashed()->get()->first();
    }

    public function getOperationalMonitoringDataComment(): ?Comment
    {
        return $this->operationalMonitoringDataComment()->withTrashed()->get()->first();
    }
}
