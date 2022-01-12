<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractAnnex\StoreContractAnnexRequest;
use App\Http\Requests\Addworking\Contract\ContractAnnex\UpdateContractAnnexRequest;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractAnnex;
use App\Repositories\Addworking\Common\FileRepository;
use App\Repositories\BaseRepository;

class ContractAnnexRepository extends BaseRepository
{
    protected $model = ContractAnnex::class;

    protected $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function createFromRequest(StoreContractAnnexRequest $request, Contract $contract): ContractAnnex
    {
        return tap($this->make(), function ($annex) use ($request, $contract) {
            $annex
                ->contract()->associate($contract)
                ->file()->associate($this->file->createFromRequest($request, 'contract_annex.file'))
                ->save();
        });
    }

    public function updateFromRequest(UpdateContractAnnexRequest $request, ContractAnnex $contract_annex): ContractAnnex
    {
        return $this->update($contract_annex, $request->input('contract_annex', []));
    }
}
