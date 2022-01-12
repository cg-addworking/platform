<?php

namespace Components\Enterprise\Enterprise\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyInvoicingDetailEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class CompanyInvoicingDetail extends Model implements CompanyInvoicingDetailEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'company_invoicing_details';

    protected $fillable = [
        'short_id',
        'accounting_year_end_date',
        'vat_number',
    ];

    protected $casts = [
        'short_id' => 'integer',
        'accounting_year_end_date' => 'string',
        'vat_number' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'accounting_year_end_date' => '12-31',
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function getVatNumber(): ?string
    {
        return $this->vat_number;
    }

    public function getAccountingYearEndDate(): string
    {
        return Carbon::createFromFormat('m-d', $this->accounting_year_end_date)->format('d F');
    }

    public function getVatExemption(): bool
    {
        return $this->vat_exemption;
    }
}
