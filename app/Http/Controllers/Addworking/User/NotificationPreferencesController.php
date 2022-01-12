<?php

namespace App\Http\Controllers\Addworking\User;

use App\Http\Controllers\Controller;
use App\Models\Addworking\User\NotificationPreferences;
use Illuminate\Http\Request;

class NotificationPreferencesController extends Controller
{
    public function edit(NotificationPreferences $notification_preferences)
    {
        $this->authorize('edit', $notification_preferences);

        return view('addworking.user.notification_preferences.edit', @compact('notification_preferences'));
    }

    public function update(NotificationPreferences $notification_preferences, Request $request)
    {
        $this->authorize('update', $notification_preferences);

        $updated = $notification_preferences->update($request->input('notification_preferences'));

        return redirect_when(
            $updated,
            route('addworking.user.notification_preferences.edit', $notification_preferences)
        );
    }
}
