<?php

namespace App\Http\Controllers\Edenred\Mission;

use App\Http\Controllers\Addworking\Mission\ProfileController as Controller;

class ProfileController extends Controller
{
    protected $views = [
        'create' => 'edenred.mission.profile.create',
    ];
}
