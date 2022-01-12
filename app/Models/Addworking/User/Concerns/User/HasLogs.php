<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\User\UserLog;
use Illuminate\Http\Request;

trait HasLogs
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log()
    {
        return $this->hasMany(UserLog::class);
    }
}
