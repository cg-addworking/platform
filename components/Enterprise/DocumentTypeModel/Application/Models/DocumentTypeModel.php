<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DocumentTypeModel extends Model implements DocumentTypeModelEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_document_type_models";

    protected $fillable = [
        'name',
        'display_name',
        'short_id',
        'signature_page',
        'content',
        'description',
        'published_at',
        'requires_documents',
        'is_primary',
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'published_at' => 'datetime',
        'requires_documents' => 'boolean',
        'is_primary' => 'boolean',
    ];

    protected $attributes = [
        'signature_page' => 1,
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id')->withDefault();
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id')->withDefault();
    }

    public function variables()
    {
        return $this->hasMany(DocumentTypeModelVariable::class);
    }

    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setFile(File $file): void
    {
        $this->file()->associate($file);
    }

    public function setDocumentType(DocumentType $document_type): void
    {
        $this->documentType()->associate($document_type);
    }

    public function setVariables(DocumentTypeModelVariable $document_type_model_variables): void
    {
        $this->variables()->attach($document_type_model_variables);
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setName(string $display_name): void
    {
        $this->name = Str::slug($display_name);
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setShortId(): void
    {
        $this->short_id = 1 + (int) self::withTrashed()->get()->max('short_id');
    }

    public function setSignaturePage(int $signature_page): void
    {
        $this->signature_page = $signature_page;
    }

    public function setPublishedAt()
    {
        $this->published_at = Carbon::now();
    }

    public function setPublishedBy($user)
    {
        $this->publishedBy()->associate($user);
    }

    public function setRequiresDocuments(bool $value): void
    {
        $this->requires_documents = $value;
    }

    public function setIsPrimary(bool $value): void
    {
        $this->is_primary = $value;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSignaturePage(): ?int
    {
        return $this->signature_page;
    }

    public function getShortId(): int
    {
        return $this->short_id;
    }

    public function getVariables()
    {
        return $this->variables()->get();
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDocumentType(): ?DocumentType
    {
        return $this->documentType()->first();
    }

    public function getPublishedAt()
    {
        return $this->published_at;
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getRequiresDocuments(): ?bool
    {
        return $this->requires_documents;
    }

    public function getIsPrimary(): ?bool
    {
        return $this->is_primary;
    }
}
