<?php

namespace App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function create(Enterprise $enterprise, Offer $offer, Request $request)
    {
        $jobs  = $enterprise->ancestors(true)->jobs()->with('skills')->get();
        $items = $enterprise
            ->vendors()
            ->when($request->input('filter.skills'), function ($query, $skills) {
                $query->whereHas('passworks', function ($query) use ($skills) {
                    $query->whereHas('skills', function ($query) use ($skills) {
                        $query->whereIn('id', $skills);
                    });
                });
            })
            ->orderBy('name', 'asc')
            ->get();

        return view($this->views['create'] ?? 'addworking.mission.profile.create', @compact('items', 'offer', 'jobs'));
    }
}
