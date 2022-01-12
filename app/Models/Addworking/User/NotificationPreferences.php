<?php

namespace App\Models\Addworking\User;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class NotificationPreferences extends Model implements Htmlable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = 'addworking_user_notification_preferences';

    protected $fillable = [
        'email_enabled',
        'confirmation_vendors_are_paid',
        'iban_validation',
        'mission_tracking_created',
    ];

    protected $casts = [
        'email_enabled' => "boolean",
        'confirmation_vendors_are_paid' => "boolean",
        'iban_validation' => "boolean",
        'mission_tracking_created' => "boolean",
    ];

    protected $routePrefix = "addworking.user.notification_preferences";

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
