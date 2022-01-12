<?php

namespace Components\Mission\TrackingLine\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\CsvLoaderReport;
use App\Models\Addworking\Common\File;
use Components\Mission\TrackingLine\Application\Loaders\TrackingLineCsvLoader;
use Illuminate\Http\Request;

class TrackingLineController extends Controller
{
    public function import()
    {
        return view('tracking_line::tracking_line.import');
    }

    public function load(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:4000|min:1',
        ]);

        $file   = File::from($request->file('file'))->saveAndGet();
        $loader = new TrackingLineCsvLoader;
        $loader->setFile($file->asSplFileObject());
        $loader->run();

        $report = CsvLoaderReport::create(
            ['label' => "Import des lignes de suivi de mission"] + @compact('loader')
        );

        return redirect($report->routes->show);
    }
}
