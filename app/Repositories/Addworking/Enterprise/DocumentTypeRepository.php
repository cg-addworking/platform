<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentTypeRepository extends BaseRepository
{
    protected $model = DocumentType::class;

    public function createFromRequest(Request $request, Enterprise $enterprise): DocumentType
    {
        return DB::transaction(function () use ($request, $enterprise) {
            $type = $this->make();
            $type->fill($request->input('type') + [
                'name' => Str::slug($request->input('type.display_name')),
            ]);
            $type->enterprise()->associate($enterprise);
            $this->associateFile($type, $request);
            $type->setNeedAnAuthenticityCheck($request->input('type.need_an_authenticity_check') ?? false);
            if (!is_null($request->input('document_type.deadline_date'))) {
                $type->setDeadlineDate($request->input('document_type.deadline_date'));
            }
            $type->save();
            $type->legalForms()->sync($request->input('type.legal_form'));

            return $type;
        });
    }

    public function updateFromRequest(DocumentType $type, Request $request, Enterprise $enterprise): DocumentType
    {
        return DB::transaction(function () use ($request, $type) {
            $type->fill($request->input('type'));
            $this->associateFile($type, $request);
            $type->setNeedAnAuthenticityCheck($request->input('type.need_an_authenticity_check') ?? false);
            if (! is_null($request->input('document_type.deadline_date'))) {
                $type->setDeadlineDate($request->input('document_type.deadline_date'));
            }
            $type->save();
            $type->legalForms()->sync($request->input('type.legal_form'));

            return $type;
        });
    }

    protected function associateFile(DocumentType $type, Request $request)
    {
        if ($request->hasFile('type.file')) {
            $type->file()->associate(
                tap(File::from($request->file('type.file')), function ($file) {
                    $file->name("/%uniq%-%ts%.%ext%")->save();
                })
            );
        }
    }

    public static function getAvailableTypes(bool $translate = false): array
    {
        $types = [
            DocumentType::TYPE_LEGAL       => __("Document Légal"),
            DocumentType::TYPE_BUSINESS    => __("Document Métier"),
            DocumentType::TYPE_INFORMATIVE => __("Document d'Information"),
            DocumentType::TYPE_CONTRACTUAL  => __("Document Contractuel"),
        ];

        return $translate ? $types : array_keys($types);
    }

    public function findByNameAndEnterprise(string $name, Enterprise $enterprise)
    {
        return DocumentType::whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        })->where('name', $name)->first();
    }

    public function isLegal(DocumentType $type)
    {
        return $type->type === DocumentType::TYPE_LEGAL;
    }
}
