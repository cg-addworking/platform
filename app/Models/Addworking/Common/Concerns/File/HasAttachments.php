<?php

namespace App\Models\Addworking\Common\Concerns\File;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use LogicException;

trait HasAttachments
{
    public function attachments()
    {
        return $this->morphMany(File::class, 'attachable');
    }

    public function attach($file): self
    {
        if (! $this->exists) {
            throw new LogicException("unable to attach a file to a non-existing object");
        }

        if (! $file instanceof File) {
            $file = File::from($file);
        }

        $file->attachTo($this)->save();

        return $this;
    }

    public function detach($file): bool
    {
        if (! $this->exists) {
            throw new LogicException("unable to detach a file from a non-existing object");
        }

        return $file->detachFrom($this)->save();
    }

    public function hasAttachments(): bool
    {
        return $this->attachments()->count() > 0;
    }
}
