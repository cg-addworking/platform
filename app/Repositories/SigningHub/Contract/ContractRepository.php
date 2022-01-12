<?php

namespace App\Repositories\SigningHub\Contract;

use App\Contracts\RepositoryInterface;
use App\Jobs\Addworking\Contract\Synchronize;
use App\Models\Addworking\Contract\Contract;
use Illuminate\Support\Facades\Config;

class ContractRepository implements RepositoryInterface
{
    public static function getContractFromSigningHubPackage($id): Contract
    {
        return Contract::where('signinghub_package_id', $id)->firstOrFail();
    }
}
