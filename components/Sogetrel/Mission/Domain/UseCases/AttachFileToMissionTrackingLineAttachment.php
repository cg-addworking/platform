<?php

namespace Components\Sogetrel\Mission\Domain\UseCases;

use Components\Common\Common\Domain\Interfaces\FileRepositoryInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentEntityInterface;
use Components\Sogetrel\Mission\Domain\Interfaces\MissionTrackingLineAttachmentRepositoryInterface;
use Components\User\User\Domain\Interfaces\UserServiceInterface;

class AttachFileToMissionTrackingLineAttachment
{
    private $attachments;
    private $files;
    private $userService;

    public function __construct(
        MissionTrackingLineAttachmentRepositoryInterface $attachments,
        FileRepositoryInterface $files,
        UserServiceInterface $userService
    ) {
        $this->attachments = $attachments;
        $this->files = $files;
        $this->userService = $userService;
    }

    public function handle(MissionTrackingLineAttachmentEntityInterface $attachment, \SplFileInfo $file): bool
    {
        $file = $this->files->makeFrom($file)->setOwner(
            $this->userService->getAuthenticatedUser()
        );

        $this->files->save($file);
        $attachment->setFile($file);

        return $this->attachments->save($attachment);
    }
}
