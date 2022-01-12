<?php

namespace Components\Sogetrel\Mission\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Common\Common\Domain\Interfaces\RepositoryInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Illuminate\Http\Request;

interface MissionTrackingLineAttachmentRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): MissionTrackingLineAttachmentEntityInterface;

    public function make(): MissionTrackingLineAttachmentEntityInterface;

    public function getSearchableAttributes(): array;

    public function list(Request $request);

    public function searchByFieldName($query, $search, $field_name, $operator);
}
