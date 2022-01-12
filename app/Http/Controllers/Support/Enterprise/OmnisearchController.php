<?php

namespace App\Http\Controllers\Support\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\DatabaseCommands\Helpers\ModelFinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OmnisearchController extends Controller
{
    public function index()
    {
        $this->authorize('omnisearch');

        return view('support.enterprise.omnisearch.index');
    }

    public function search(Request $request)
    {
        $this->authorize('omnisearch');

        $models = App::make('laravel-models')->findAll($request->search);

        if ($models->isEmpty() && strlen($request->search) >= 3) {
            $models = Enterprise::where('name', 'like', "%" . strtoupper($request->search) . "%")->get();
        }

        return view('support.enterprise.omnisearch.index', @compact('models'));
    }
}
