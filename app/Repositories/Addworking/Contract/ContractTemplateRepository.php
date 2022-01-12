<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractTemplate\StoreContractTemplateRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplate\UpdateContractTemplateRequest;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use UnexpectedValueException;

class ContractTemplateRepository extends BaseRepository
{
    protected $model = ContractTemplate::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return ContractTemplate::query()
            ->when($filter['display_name'] ?? null, function ($query, $display_name) {
                return $query->whereDisplayName($display_name);
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): ContractTemplate
    {
        return tap($this->make([
            'name'         => str_slug($request->input('contract_template.display_name')),
            'display_name' => $request->input('contract_template.display_name'),
        ]), function ($template) use ($enterprise) {
            $template->enterprise()->associate($enterprise)->save();
        });
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, ContractTemplate $template)
    {
        return tap($template, function ($contract_template) use ($request) {
            $contract_template->fill(['name'  => str_slug($request->input('contract_template.display_name'))]
                + $request->input('contract_template'))
            ->save();
        });
    }
}
