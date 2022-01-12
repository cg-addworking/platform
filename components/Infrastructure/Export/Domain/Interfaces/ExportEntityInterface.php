<?php

namespace Components\Infrastructure\Export\Domain\Interfaces;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;

interface ExportEntityInterface
{
    const STATUS_GENERATION_PROCESSING = 'generation_processing';
    const STATUS_GENERATED             = 'generated';
    const STATUS_FAILED                = 'failed';

    public function setUser(User $user);
    public function setFile(File $file);
    public function setStatus(string $status): void;
    public function setErrorMessage(string $error_message): void;
    public function setFinishedAt($finished_at): void;
    public function setName(string $name): void;

    public function getUser(): User;
    public function getFile(): ?File;
    public function getName(): string;
    public function getStatus(): string;
    public function getFilters();
    public function getFinishedAt();
    public function getCreatedAt();
}
