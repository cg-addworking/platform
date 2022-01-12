<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\User\User;
use Illuminate\Database\Eloquent\Builder;

trait HasConfirmationToken
{
    protected $confirmationTokenName = 'confirmation_token';

    public function getConfirmationToken(): ?string
    {
        if (! empty($this->getConfirmationTokenName())) {
            return $this->{$this->getConfirmationTokenName()};
        }

        return null;
    }

    public function setConfirmationToken(string $value): User
    {
        if (! empty($this->getConfirmationTokenName())) {
            $this->{$this->getConfirmationTokenName()} = $value;
        }

        return $this;
    }

    public function forgetConfirmationToken(): User
    {
        return $this->setConfirmationToken('');
    }

    public function getConfirmationTokenName(): string
    {
        return $this->confirmationTokenName;
    }


    public function scopeWhereConfirmationToken(Builder $query, string $value): Builder
    {
        return $query->where($this->getConfirmationTokenName(), '=', $value);
    }
}
