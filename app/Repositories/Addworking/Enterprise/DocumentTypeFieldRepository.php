<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Enterprise\DocumentTypeField;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentTypeFieldRepository extends BaseRepository
{
    protected $model = DocumentTypeField::class;

    public function createFromRequest(Request $request): DocumentTypeField
    {
        $field = new DocumentTypeField;
        $field->fill($request->input('field'));
        $field->name = $request->input('field.display_name');
        $field->documentType()->associate($request->input('field.type_id'));
        $field->save();

        return $field;
    }

    public function updateFromRequest(DocumentTypeField $field, Request $request): DocumentTypeField
    {
        $field->update($request->input('field') + ['name' => $request->input('field.display_name')]);

        return $field;
    }
}
