<?php

namespace App\Http\Controllers\Addworking\User;

use App\Domain\Sogetrel\UserLogCsvBuilder;
use App\Http\Controllers\Controller;
use App\Models\Addworking\User\UserLog;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', UserLog::class);

        $query = UserLog::orderBy('created_at', 'DESC');

        if ($request->has('search')) {
            $search = trim($request->input('search'));
            $query->whereHas('user', function ($query) use ($search) {
                $query->search($search);
            });
        }

        $items = $query->paginate(25);

        return view('addworking.user.log.index', @compact('items'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $this->authorize('export', UserLog::class);

        $logs = UserLog::where('impersonating', false)
            ->whereHas('user', function ($query) use ($request) {
                $query->whereHas('enterprises', function ($query) use ($request) {
                    $query->where('name', 'like', "%".strtoupper($request->input('enterprise'))."%");
                });
            })->latest()->get();

        return (new UserLogCsvBuilder)->addAll($logs)->download();
    }
}
