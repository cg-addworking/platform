<?php

namespace App\Http\Controllers\Spie\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise as AddworkingEnterprise;
use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\Order;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Enterprise::class);

        $spie_model = new Enterprise;
        $spie_table = $spie_model->getTable();
        $spie_fk    = $spie_model->enterprise()->getForeignKeyName();

        $addw_model = new AddworkingEnterprise;
        $addw_table = $addw_model->getTable();
        $addw_key   = $addw_model->getKeyName();

        $items = Enterprise::query()
            ->join($addw_table, "{$spie_table}.{$spie_fk}", "=", "{$addw_table}.{$addw_key}")
            ->select("{$spie_table}.*", "{$addw_table}.name")
            ->with('enterprise', 'coverageZones', 'qualifications', 'orders')
            ->orderBy("name")
            ->filter($request->input('filter', []))
            ->paginate(25);

        return view('spie.enterprise.enterprise.index', @compact('items'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Enterprise $enterprise)
    {
        //
    }

    public function edit(Enterprise $enterprise)
    {
        //
    }

    public function update(Request $request, Enterprise $enterprise)
    {
        //
    }

    public function destroy(Enterprise $enterprise)
    {
        //
    }
}
