<?php

namespace App\Jobs\Addworking\Contract\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateBlankContractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $enterprise;
    public $properties;
    public $contract;

    public function __construct(Enterprise $enterprise, array $properties = [])
    {
        $this->enterprise = $enterprise;
        $this->properties = $properties;
    }

    public function handle()
    {
        $this->contract = $this->enterprise->contracts()->make($this->properties + [
            'status' => Contract::STATUS_DRAFT,
        ]);

        return $this->contract->save();
    }
}
