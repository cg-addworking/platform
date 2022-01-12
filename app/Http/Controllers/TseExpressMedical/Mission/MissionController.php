<?php

namespace App\Http\Controllers\TseExpressMedical\Mission;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\CsvLoaderReport;
use App\Models\Addworking\Common\File;
use App\Models\TseExpressMedical\Mission\MissionCsvLoader;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Display an import page.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('tse_express_medical.mission.import');
    }

    public function load(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:4000|min:1',
        ]);

        $file   = File::from($request->file('file'))->saveAndGet();
        $loader = new MissionCsvLoader;
        $loader->setFile($file->asSplFileObject());
        $loader->run();

        $report = CsvLoaderReport::create(
            ['label' => "Import des missions pour TSE Express Medical"] + @compact('loader')
        );

        return redirect($report->routes->show);
    }
}
