<?php

namespace Components\Common\Common\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\FileImmutableInterface;
use Components\Common\Common\Domain\Interfaces\ImmutableRepositoryInterface;

interface FileRepositoryInterface extends RepositoryInterface
{
    public function find(string $uuid): FileImmutableInterface;

    public function make(): FileImmutableInterface;
}
