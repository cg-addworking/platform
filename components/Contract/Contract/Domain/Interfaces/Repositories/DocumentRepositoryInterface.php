<?php
namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use App\Models\Addworking\Enterprise\Document;

interface DocumentRepositoryInterface
{
    public function make(): Document;
}
