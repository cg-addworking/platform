<?php

namespace App\Console\Commands\Sogetrel\User;

use App\Models\Sogetrel\User\Passwork;
use App\Notifications\Sogetrel\User\Passwork\VendorEditNotification;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PassworkVendorEdit extends Command
{
    protected $signature = 'sogetrel:user:passwork-vendor-edit';

    protected $description = '';

    public function handle()
    {
        foreach (Passwork::cursor() as $passwork) {
            if (!in_array($passwork->status, ['refused', 'blacklisted'])) {
                Notification::send($passwork->user, new VendorEditNotification($passwork));
            }
            unset($passwork);
            gc_collect_cycles();
        }
    }
}
