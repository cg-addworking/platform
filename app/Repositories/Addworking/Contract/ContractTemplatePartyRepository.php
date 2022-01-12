<?php

namespace App\Repositories\Addworking\Contract;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Contract\ContractTemplateParty\StoreContractTemplatePartyRequest;
use App\Http\Requests\Addworking\Contract\ContractTemplateParty\UpdateContractTemplatePartyRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Repositories\BaseRepository;

class ContractTemplatePartyRepository extends BaseRepository
{
    protected $model = ContractTemplateParty::class;

    public function createFromRequest(
        StoreContractTemplatePartyRequest $request,
        ContractTemplate $template
    ): ContractTemplateParty {
        return tap($this->make([
            'order'        => $template->contractTempateParties()->max('order') + 1,
            'denomination' => $request->input('contract_template_party.denomination'),
        ]), function ($party) use ($template) {
            $party->contractTemplate()->associate($template)->save();
        });
    }

    public function updateFromRequest(
        UpdateContractTemplatePartyRequest $request,
        ContractTemplateParty $contract_template_party
    ): ContractTemplateParty {
        return $this->update($contract_template_party, $request->input('contract_template_party', []));
    }
}
