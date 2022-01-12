<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplate;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractTemplateAnnex extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "addworking_contract_contract_template_annexes";

    protected $viewPrefix = "addworking.contract.contract_template_annex";

    protected $routePrefix = "addworking.contract.contract_template_annex";

    public function __toString()
    {
        return (string) $this->file;
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractTemplate()
    {
        return $this->belongsTo(ContractTemplate::class)->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }
}
