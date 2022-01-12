<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Common\File\StoreFileRequest;
use App\Http\Requests\Addworking\Common\File\UpdateFileRequest;
use App\Jobs\Addworking\Common\File\SendToStorageJob;
use App\Models\Addworking\Common\File;
use App\Repositories\Addworking\Common\FileRepository;
use Components\Infrastructure\FileDataExtractor\Application\Validators\UrssafCertificateDocumentValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataExtractorServiceInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentSplitterServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FileController extends Controller
{
    protected $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', File::class);

        $items = $this->repository
            ->list($request->input('search'), $request->input('filter'))
            ->latest()
            ->paginate(25);

        return view('addworking.common.file.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', File::class);

        $file = new File;

        return view('addworking.common.file.create', @compact('file'));
    }

    public function store(StoreFileRequest $request)
    {
        $this->authorize('create', File::class);

        $file = $this->repository->createFromRequest($request);

        return redirect_when($file->exists, $request->input('file.return-to', $file->routes->show));
    }

    public function show(File $file)
    {
        $this->authorize('show', File::class);

        return view('addworking.common.file.show', @compact('file'));
    }

    public function ocrScanUrssaf(File $file)
    {
        $this->authorize('ocrScan', File::class);

        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . config('ocr.google_application_credentials')
        );

        $temp = tmpfile();
        fwrite($temp, $file->content);
        $pdfPath = stream_get_meta_data($temp)['uri'];


        $validator = App::make(UrssafCertificateDocumentValidator::class);
        $response = $validator->check(new \SplFileInfo($pdfPath));

        dd($response, $response->isValid());
    }

    public function ocrScan(File $file)
    {
        $this->authorize('ocrScan', File::class);

        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . config('ocr.google_application_credentials')
        );
        $temp = tmpfile();
        fwrite($temp, $file->content);
        $pdfPath = stream_get_meta_data($temp)['uri'];

        $newPdf = $pdfPath.uniqid();
        exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.7 -dNOPAUSE -dBATCH -sOutputFile=".$newPdf." ".$pdfPath);

        $splitedPdfs = App::make(DocumentSplitterServiceInterface::class)->splitPdf($newPdf);

        if ($splitedPdfs === []) {
            return;
        }

        $documentDatas = [];
        $service = App::make(DocumentDataExtractorServiceInterface::class);
        foreach ($splitedPdfs as $splited_pdf) {
            $documentDatas[] = $service->extractDataFrom(new \SplFileInfo($splited_pdf));
        }

        dd($documentDatas);
    }

    public function edit(File $file)
    {
        $this->authorize('edit', $file);

        return view('addworking.common.file.edit', @compact('file'));
    }

    public function update(UpdateFileRequest $request, File $file)
    {
        $this->authorize('update', $file);

        $file = $this->repository->updateFromRequest($request, $file);

        return redirect_when($file->exists, $request->input('file.return-to', $file->routes->show));
    }

    public function destroy(File $file)
    {
        $this->authorize('destroy', $file);

        $deleted = $file->delete();

        return redirect()->back()->with($deleted ? success_status() : error_status());
    }

    public function download(File $file)
    {
        $this->authorize('download', $file);

        return $file->download();
    }

    public function iframe(File $file)
    {
        $this->authorize('iframe', $file);

        return response()->file($file->temp());
    }

    public function logo(File $file)
    {
        return response()->file($file->temp());
    }
}
