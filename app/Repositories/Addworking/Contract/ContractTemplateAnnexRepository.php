<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractTemplateAnnex\StoreContractTemplateAnnexRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateAnnex\UpdateContractTemplateAnnexRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateAnnex;
use App\Repositories\Addworking\Common\FileRepository;
use App\Repositories\BaseRepository;

class ContractTemplateAnnexRepository extends BaseRepository
{
    protected $model = ContractTemplateAnnex::class;

    protected $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function createFromRequest(
        StoreContractTemplateAnnexRequest $request,
        ContractTemplate $contract_template
    ): ContractTemplateAnnex {
        return tap($this->make(), function ($annex) use ($request, $contract_template) {
            $annex
                ->contractTemplate()->associate($contract_template)
                ->file()->associate($this->file->createFromRequest($request, 'contract_template_annex.file'))
                ->save();
        });
    }

    public function updateFromRequest(
        UpdateContractTemplateAnnexRequest $request,
        ContractTemplateAnnex $contract_template_annex
    ): ContractTemplateAnnex {
        return $this->update($contract_template_annex, $request->input('contract_template_annex', []));
    }
}
