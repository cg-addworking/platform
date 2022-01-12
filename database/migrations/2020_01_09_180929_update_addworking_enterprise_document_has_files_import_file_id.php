<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateAddworkingEnterpriseDocumentHasFilesImportFileId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $documents = DB::table('addworking_enterprise_documents')->select([
            'id',
            'file_id',
            'created_at',
            'updated_at'
        ])->cursor();

        foreach ($documents as $document) {
            DB::table('addworking_enterprise_document_has_files')->insert([
                'document_id' => $document->id,
                'file_id' => $document->file_id,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (DB::table('addworking_enterprise_document_has_files')->cursor() as $pivot) {
            DB::table('addworking_enterprise_documents')
                ->where('id', $pivot->document_id)
                ->update([
                    'file_id' => $pivot->file_id
                ]);
        }
    }
}
