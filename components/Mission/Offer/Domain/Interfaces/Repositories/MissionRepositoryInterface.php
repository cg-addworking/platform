<?php

namespace Components\Mission\Offer\Domain\Interfaces\Repositories;

use Components\Mission\Offer\Application\Models\Response;

interface MissionRepositoryInterface
{
    public function createFromResponse(Response $response);
}
