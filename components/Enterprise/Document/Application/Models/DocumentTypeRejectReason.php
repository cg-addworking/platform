<?php

namespace Components\Enterprise\Document\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeRejectReasonIsNotFoundException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeRejectReasonEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentTypeRejectReason extends Model implements DocumentTypeRejectReasonEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_document_reject_reasons";

    protected $fillable = [
        'name',
        'display_name',
        'message',
        'number',
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDocumentType($document_type): void
    {
        $this->documentType()->associate($document_type);
    }

    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getDocumentType(): ?DocumentTypeEntityInterface
    {
        return $this->documentType()->first();
    }

    public function getId(): string
    {
        if (! $this->exists) {
            throw new DocumentTypeRejectReasonIsNotFoundException($this);
        }

        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
