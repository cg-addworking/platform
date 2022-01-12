<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class LegalFormRepository extends BaseRepository
{
    protected $model = LegalForm::class;

    public function createFromRequest(Request $request): LegalForm
    {
        return $this->updateFromRequest($request, $this->make());
    }

    public function updateFromRequest(Request $request, LegalForm $legal_form): LegalForm
    {
        $legal_form->fill($request->input('legal_form'))->save();
        
        return $legal_form;
    }

    public function findByName(string $name)
    {
        return LegalForm::where('name', $name)->first();
    }
}
