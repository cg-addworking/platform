<?php

namespace App\Http\Controllers\Sogetrel\User;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\File;
use App\Models\Sogetrel\User\Passwork;

class PassworkFileController extends Controller
{
    public function create(Passwork $passwork)
    {
        $this->authorize('create', File::class);

        $file = new File();

        return view('sogetrel.user.passwork.create-file', @compact('passwork', 'file'));
    }

    public function show(Passwork $passwork, File $file)
    {
        $this->authorize('show', $file);

        return view('sogetrel.user.passwork.show-file', @compact('passwork', 'file'));
    }
}
