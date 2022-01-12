<?php

namespace App\Rules;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\InvitationRepository;
use Illuminate\Contracts\Validation\Rule;

class CanSendInvitation implements Rule
{
    protected $host;
    protected $message;

    public function __construct(Enterprise $host)
    {
        $this->host = $host;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return true === ($this->message = InvitationRepository::canSend($value, $this->host->id));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
