<?php

namespace Components\Common\Common\Domain\Interfaces;

use Components\Common\Common\Domain\Interfaces\ImmutableInterface;
use Components\User\User\Domain\Interfaces\UserEntityInterface;

interface FileImmutableInterface extends ImmutableInterface
{
    public function getFileInfo(): \SplFileInfo;

    public function hasParent(): bool;

    public function getParent(): ?self;

    public function setParent(self $file): self;

    public function getChildren(): FileCollectionInterface;

    public function getOwner(): UserEntityInterface;

    public function setOwner(UserEntityInterface $user): self;

    public function getName(): string;

    public function setName(string $name): self;

    public function getMimeType(): string;

    public function setMimeType(string $mime): self;

    public function getExtension(): ?string;

    public function getContent(): string;

    public function setContent(string $content): self;

    public function isText(): bool;

    public function isPdf(): bool;
}
