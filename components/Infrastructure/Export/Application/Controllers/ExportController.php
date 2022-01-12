<?php

namespace Components\Infrastructure\Export\Application\Controllers;

use App\Http\Controllers\Controller;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Components\Infrastructure\Export\Application\Repositories\UserRepository;

class ExportController extends Controller
{
    protected $userRepository;
    protected $exportRepository;

    public function __construct(
        UserRepository $userRepository,
        ExportRepository $exportRepository
    ) {
        $this->userRepository = $userRepository;
        $this->exportRepository = $exportRepository;
    }

    public function index()
    {
        $user = $this->userRepository->connectedUser();

        $items = $this->exportRepository->list($user);

        return view('export::export.index', compact('items', 'user'));
    }

    public function download(Export $export)
    {
        $this->authorize('download', $export);

        return $export->getFile()->download();
    }
}
