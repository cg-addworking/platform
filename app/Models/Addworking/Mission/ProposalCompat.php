<?php

namespace App\Models\Addworking\Mission;

use App\Repositories\Addworking\Mission\ProposalRepository;
use Components\Infrastructure\Foundation\Application\Deprecated;

trait ProposalCompat
{
    use Deprecated;

    /**
     * @deprecated v0.52.7 replaced by ProposalRepository::isExpired
     */
    public function isExpired()
    {
        self::deprecated(__METHOD__, "ProposalRepository::isExpired");

        return app(ProposalRepository::class)->isExpired($this);
    }
}
