<?php

namespace App\Http\Controllers\Sogetrel\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sogetrel\User\PassworkSavedSearch;
use App\Models\Sogetrel\User\PassworkSavedSearchSchedule;
use Illuminate\Support\Facades\Auth;

class PassworkSavedSearchController extends Controller
{

    public function index()
    {
        $passwork_saved_searches = auth()->user()->passworkSavedSearches()->latest()->paginate(25);

        return view('sogetrel.user.passwork_saved_search.index', @compact('passwork_saved_searches'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $saved = transaction(function () use ($request) {
            $passworkSavedSearch = new PassworkSavedSearch([
                'name' => $request->name,
                'search' => $request->search,
            ]);

            $passworkSavedSearch->user()->associate(auth()->user());

            return $passworkSavedSearch->save();
        });

        return redirect_when(
            $saved,
            route('sogetrel.saved_search.index'),
            "Critères de recherche des passworks enregistrés",
            "Une erreur s'est produite lors de l'enregistrement des critères de recherche"
        );
    }

    public function show($id)
    {
        abort(501); // Not Implemented
    }

    public function edit($id)
    {
        abort(501); // Not Implemented
    }

    public function update(Request $request, $id)
    {
        abort(501); // Not Implemented
    }

    public function destroy(PassworkSavedSearch $saved_search)
    {
        $deleted = $saved_search->delete();

        return redirect_when(
            $deleted,
            route('sogetrel.saved_search.index'),
            "critères de recherche supprimés avec succès",
            "Erreur lors de la suppression des critères de recherche"
        );
    }

    public function schedule(Request $request, $saved_search)
    {
        $saved = transaction(function () use ($request, $saved_search) {
            $schedule = new PassworkSavedSearchSchedule([
                    'email' => $request->email,
                    'frequency' => $request->frequency
            ]);
            $schedule->passworkSavedSearch()->associate($saved_search);

            return $schedule->save();
        });

        return redirect_when(
            $saved,
            route('sogetrel.saved_search.index'),
            "Paramètres des notifications enregistrés",
            "Une erreur s'est produite lors de l'enregistrement"
        );
    }
}
