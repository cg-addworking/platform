<?php

namespace Components\Enterprise\Document\Application\Models;

use App\Models\Addworking\Enterprise\DocumentTypeField;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model implements DocumentEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'addworking_enterprise_documents';

    protected $fillable = [
        'file',
        'status',
        'reason_for_rejection',
        'valid_from',
        'valid_until',
        'accepted_at',
        'rejected_at',
        'last_notified_at',
        'is_pre_check',
        'signed_at',
        'yousign_file_id',
        'yousign_procedure_id',
        'yousign_member_id',
        'signatory_name',
    ];

    protected $attributes = [
        'status'               => self::STATUS_PENDING,
        'reason_for_rejection' => null,
        'valid_until'          => null,
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'last_notified_at' => 'datetime',
        'signed_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'type_id')->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'addworking_enterprise_document_has_files',
            'document_id',
            'file_id'
        )->withTimestamps();
    }

    public function fields()
    {
        return $this
            ->belongsToMany(
                DocumentTypeField::class,
                'addworking_enterprise_document_has_fields',
                'document_id',
                'field_id'
            )
            ->withPivot('content')
            ->whereNull('addworking_enterprise_document_has_fields.deleted_at')
            ->withTimestamps();
    }

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by')->withDefault();
    }

    public function documentTypeModel()
    {
        return $this->belongsTo(DocumentTypeModel::class, 'document_type_model_id')->withDefault();
    }

    public function requiredDocument()
    {
        return $this->belongsTo(File::class, "required_document_id")->withDefault();
    }

    // ------------------------------------------------------------------------
    // Setters
    // ------------------------------------------------------------------------

    public function setEnterprise(Enterprise $enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setDocumentTypeModel(DocumentTypeModelEntityInterface $document_type_model)
    {
        $this->documentTypeModel()->associate($document_type_model);
    }

    public function setDocumentType($document_type)
    {
        $this->documentType()->associate($document_type);
    }

    public function setFiles($files)
    {
        $this->files()->attach($files);
    }

    public function setSignedBy($signed_by)
    {
        $this->signedBy()->associate($signed_by);
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setValidFrom($date)
    {
        $this->valid_from = $date;
    }

    public function setValidUntil($date)
    {
        $this->valid_until = $date;
    }

    public function setSignedAt($signed_at)
    {
        $this->signed_at = $signed_at;
    }

    public function setIsPreCheck(bool $is_pre_check)
    {
        $this->is_pre_check = $is_pre_check;
    }

    public function setYousignFileId(string $yousign_file_id)
    {
        $this->yousign_file_id = $yousign_file_id;
    }

    public function setYousignProcedureId(string $yousign_procedure_id)
    {
        $this->yousign_procedure_id = $yousign_procedure_id;
    }

    public function setYousignMemberId(string $yousign_member_id)
    {
        $this->yousign_member_id = $yousign_member_id;
    }

    public function setRequiredDocument(File $file)
    {
        $this->requiredDocument()->associate($file)->save();
    }

    public function setSignatoryName(?string $signatory_name)
    {
        $this->signatory_name = $signatory_name;
    }

    // ------------------------------------------------------------------------
    // Getters
    // ------------------------------------------------------------------------

    public function getSignedBy()
    {
        return $this->signedBy()->first();
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getDocumentTypeModel()
    {
        return $this->documentTypeModel()->first();
    }

    public function getDocumentType()
    {
        return $this->documentType()->first();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getYousignMemberId(): string
    {
        return $this->yousign_member_id;
    }

    public function getYousignFileId(): string
    {
        return $this->yousign_file_id;
    }

    public function getRequiredDocument(): ?File
    {
        return $this->requiredDocument()->first();
    }

    public function getSignatoryName(): ?string
    {
        return $this->signatory_name;
    }

    public function getSignedAt()
    {
        return $this->signed_at;
    }
}
