<?php

namespace Components\Sogetrel\Mission\Application\Controllers;

use App\Models\Addworking\Mission\Offer;
use App\Models\Sogetrel\User\Passwork;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesPagination;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesSearch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use HandlesSearch, HandlesPagination;

    public function create(Request $request, Offer $offer)
    {
        $this->handleSearch($request)->handlePagination($request);

        $passworks = Passwork::search($request)->latest()->paginate(25);

        return view('sogetrel.mission.profile.create', @compact('passworks', 'offer'));
    }
}
