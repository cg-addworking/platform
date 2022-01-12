<?php

namespace App\Http\Controllers\Sogetrel\User;

use App\Domain\Sogetrel\PassworkCsvBuilderJob;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sogetrel\User\Passwork\StatusRequest;
use App\Http\Requests\Sogetrel\User\Passwork\StoreRequest;
use App\Http\Requests\Sogetrel\User\Passwork\UpdateRequest;
use App\Models\Sogetrel\User\Passwork;
use App\Notifications\Sogetrel\User\Passwork\AcceptedStatusNotification;
use App\Repositories\Addworking\Common\CommentRepository;
use App\Repositories\Sogetrel\User\PassworkRepository;
use Carbon\Carbon;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PassworkController extends Controller
{
    protected $passworkRepository;

    public function __construct(PassworkRepository $passwork_repository)
    {
        $this->passworkRepository = $passwork_repository;
    }

    public function index(Request $request, PassworkSavedSearchController $passworkSavedSearchController)
    {
        $this->authorize('index', Passwork::class);

        if ($request->has('save_search')) {
            $passworkSavedSearchController->store($request);
        }

        if ($request->has('reset')) {
            $request->session()->forget([
                'sogetrel.user.passwork.index.search',
                'sogetrel.user.passwork.index.page'
            ]);
        }

        $request->has('search')
            ? $request->session()->put('sogetrel.user.passwork.index.search', $request->input('search'))
            : $request['search'] = $request->session()->get('sogetrel.user.passwork.index.search');

        $request->has('page')
            ? $request->session()->put('sogetrel.user.passwork.index.page', $request->input('page'))
            : $request['page'] = $request->session()->get('sogetrel.user.passwork.index.page');

        $passworks = Passwork::search($request)->latest()->paginate(25);

        return view('sogetrel.user.passwork.index', @compact('passworks'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Passwork::class);

        $passwork = new Passwork;

        if (config('app.env') == 'local') {
            $passwork = factory(Passwork::class)->make();
        }

        return view('sogetrel.user.passwork.create', @compact('passwork'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Passwork::class);

        $saved = transaction(function () use ($request, &$passwork) {
            $passwork = new Passwork($request->input('passwork'));
            $passwork->user()->associate(auth()->user());

            if (!$passwork->save()) {
                return false;
            }

            $passwork->departments()->sync($request->input('departments'));

            if ($request->has('file.content')) {
                $passwork->attach($request->file('file.content'));
            }

            return true;
        });

        return $saved
            ? redirect()
                ->route('dashboard')
                ->with(success_status("Passwork enregistré"))
            : back()
                ->with(error_status("Une erreur s'est produite lors de l'enregistrement du passwork"));
    }

    public function edit(Request $request, Passwork $passwork)
    {
        $this->authorize('update', $passwork);

        return view('sogetrel.user.passwork.edit', @compact('passwork'));
    }

    public function update(UpdateRequest $request, Passwork $passwork)
    {
        $this->authorize('update', $passwork);

        $saved = transaction(function () use ($request, &$passwork) {
            $passwork = Passwork::find($passwork->id)->fill($request->input('passwork'));

            if (!$passwork->save()) {
                return false;
            }

            $passwork->departments()->sync($request->input('departments'));
        });

        return $saved
            ? redirect()
                ->back()
                ->with(success_status("Passwork enregistré"))
            : back()
                ->with(error_status("Une erreur s'est produite lors de l'enregistrement du passwork"));
    }

    public function status(StatusRequest $request, Passwork $passwork)
    {
        $this->authorize('status', $passwork);

        $saved = transaction(function () use ($request, $passwork) {
            return $passwork->statusProcessing($request, $passwork);
        });

        if (in_array($request->status, [
                Passwork::STATUS_ACCEPTED_QUEUED,
                Passwork::STATUS_REFUSED,
                Passwork::STATUS_BLACKLISTED,
                Passwork::STATUS_ACCEPTED,
                Passwork::STATUS_PREQUALIFIED
            ])) {
                $passwork->update(['flag_contacted' => true]);
        }
        
        if ($request->status == Passwork::STATUS_ACCEPTED) {
            Notification::route('mail', 'julie@addworking.com')->notify(new AcceptedStatusNotification($passwork));
        }

        return $this->redirectWhen($passwork->exists, route('sogetrel.passwork.show', $passwork));
    }

    public function parking(Request $request, Passwork $passwork)
    {
        $this->authorize('parking', $passwork);

        $request->validate([
            'flag_parking' => "required|bool",
        ]);

        $saved = transaction(function () use ($request, $passwork) {
            $passwork->flag_parking = $request->flag_parking;

            return $passwork->save();
        });

        return redirect()->back()->with(
            $saved
                ? success_status("Passwork mis à jour")
                : error_status("Impossible de mettre à jour le passwork")
        );
    }

    public function contacted(Request $request, Passwork $passwork)
    {
        $this->authorize('contacted', $passwork);

        $request->validate([
            'flag_contacted' => "required|bool",
        ]);

        $saved = transaction(function () use ($request, $passwork) {
            $passwork->flag_contacted = $request->flag_contacted;

            return $passwork->save();
        });

        return redirect()->back()->with(
            $saved
                ? success_status("Passwork mis à jour")
                : error_status("Impossible de mettre à jour le passwork")
        );
    }

    public function show(Request $request, Passwork $passwork)
    {
        $this->authorize('show', $passwork);

        return view('sogetrel.user.passwork.show', @compact('passwork'));
    }

    public function destroy(Request $request, Passwork $passwork)
    {
        $this->authorize('destroy', $passwork);

        $deleted = $passwork->delete();

        return redirect()->back()->with(
            $deleted
                ? success_status("Passwork supprimé avec succès")
                : error_status("Erreur lors de la suppression du Passwork")
        );
    }

    public function pending()
    {
        $this->authorize('pending', Passwork::class);

        return view('sogetrel.user.passwork.pending');
    }

    public function export(Request $request)
    {
        $this->authorize('export', Passwork::class);

        $export = App::make(ExportRepository::class)->create(
            $request->user(),
            "export_passworks_".Carbon::now()->format('Ymd_His'),
            []
        );

        PassworkCsvBuilderJob::dispatch($export, $request->input('search'));

        return redirect()->back()->with(success_status(
            __('common.infrastructure.export.application.views.export.build_csv.csv_is_building')
        ));
    }

    public function share(Request $request, Passwork $passwork)
    {
        $this->authorize('status', $passwork);

        $this->passworkRepository->share($request, $passwork);

        return redirect()->back()->with(success_status("Passwork partagé avec succès"));
    }

    public function attachToErymaOrSubsidiaries(Passwork $passwork)
    {
        $this->authorize('attachToErymaOrSubsidiaries', $passwork);

        $enterprise = Auth::user()->enterprise;

        $passwork->customers()->attach($enterprise);

        if ($passwork->user->enterprise->exists && !$passwork->user->enterprise->isVendorOf($enterprise)) {
            $enterprise->vendors()->attach($passwork->user->enterprise, ['activity_starts_at' => Carbon::now()]);
        }

        $passwork->update(['status' => Passwork::STATUS_ACCEPTED, 'flag_contacted' => true]);
        $passwork->acceptedBy()->associate(Auth::user()->id)->save();

        $comment   = "Ce passwork a été référencé auprès de {$enterprise}.";

        App::make(CommentRepository::class)->comment($passwork, $comment, 'public', Auth::user());

        return redirect()->back()->with(success_status("Passwork attaché avec succès"));
    }
}
