<?php

namespace App\Console\Commands\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Invitation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckInvitationsExpired extends Command
{
    protected $signature = 'addworking:enterprise:check-invitations-expired';

    protected $description = 'Check if invitations are expired';

    public function handle()
    {
        Invitation::where('valid_until', '<', Carbon::now())
            ->whereIn('status', [Invitation::STATUS_PENDING, Invitation::STATUS_IN_PROGRESS])
            ->update(['status' => Invitation::STATUS_REJECTED]);
    }
}
