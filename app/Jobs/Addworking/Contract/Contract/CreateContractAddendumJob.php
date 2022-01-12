<?php

namespace App\Jobs\Addworking\Contract\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractAddendum;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateContractAddendumJob extends CreateContractFromExistingFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parent;

    public function __construct(
        Enterprise $enterprise,
        Contract $contract,
        array $properties,
        UploadedFile $file
    ) {
        parent::__construct($enterprise, $properties, $file);
        $this->parent = $contract;
    }

    public function handle()
    {
        return DB::transaction(function () {
            if (! parent::handle()) {
                return false;
            }

            $this->contract
                ->parent()
                ->associate($this->parent);

            if (! $this->contract->save()) {
                return false;
            }

            foreach ($this->parent->contractParties as $party) {
                $addendum_party = $this->contract
                    ->contractParties()
                    ->make($party->only('denomination', 'order'));

                $addendum_party
                    ->enterprise()
                    ->associate($party->enterprise);

                if (! $addendum_party->save()) {
                    return false;
                }
            }
        });
    }
}
