<?php

namespace App\Http\Controllers\Sogetrel\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sogetrel\User\Quizz\StoreRequest;
use App\Models\Sogetrel\User\Passwork;
use App\Models\Sogetrel\User\Quizz;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    public function index(Passwork $passwork)
    {
        $this->authorize('index', Quizz::class);

        $quizzes = $passwork->quizzes()->latest()->paginate(25);

        return view('sogetrel.user.quizz.index', @compact('passwork', 'quizzes'));
    }

    public function create(Passwork $passwork)
    {
        $this->authorize('create', Quizz::class);

        $quizz = new Quizz;

        if (app()->environment(['local', 'staging'])) {
            $quizz = factory(Quizz::class)->make();
        }

        return view('sogetrel.user.quizz.create', @compact('passwork', 'quizz'));
    }

    public function store(StoreRequest $request, Passwork $passwork)
    {
        $this->authorize('store', Quizz::class);

        $quizz = $passwork->quizzes()->create($request->input('quizz'));

        return redirect()->route('sogetrel.passwork.quizz.index', $passwork)->with(success_status());
    }

    public function show(Passwork $passwork, Quizz $quizz)
    {
        $this->authorize('show', $quizz);

        return view('sogetrel.user.quizz.show', @compact('passwork', 'quizz'));
    }

    public function edit(Passwork $passwork, Quizz $quizz)
    {
        $this->authorize('edit', $quizz);

        return view('sogetrel.user.quizz.edit', @compact('passwork', 'quizz'));
    }

    public function update(StoreRequest $request, Passwork $passwork, Quizz $quizz)
    {
        $this->authorize('update', $quizz);

        $updated = $quizz->update($request->input('quizz'));

        return redirect_when($updated, route('sogetrel.passwork.quizz.show', [$passwork, $quizz]));
    }

    public function destroy(Passwork $passwork, Quizz $quizz)
    {
        $this->authorize('destroy', $quizz);

        $deleted = $quizz->delete();

        return redirect_when($deleted, route('sogetrel.passwork.quizz.index', $passwork));
    }
}
