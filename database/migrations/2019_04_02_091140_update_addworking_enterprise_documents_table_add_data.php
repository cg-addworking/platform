<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class UpdateAddworkingEnterpriseDocumentsTableAddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $documents = DB::table('addworking_enterprise_enterprises_has_files')->get();

        foreach ($documents as $document) {
            switch ($document->status) {
                case 'pending_validation':
                    $status = 'pending';
                    break;

                case 'accepted':
                    $status = 'validated';
                    break;

                case 'rejected':
                    $status = 'rejected';
                    break;
                
                default:
                    $status = 'pending';
                    break;
            }
            
            DB::table('addworking_enterprise_documents')->insert([
                'id' => Uuid::generate(4),
                'type_id' => DB::table('addworking_enterprise_document_types')
                    ->where('name', $document->type)->first()->id,
                'enterprise_id' => $document->enterprise_id,
                'file_id' => $document->file_id,
                'valid_from' => ($document->valid_from ?? Carbon::now()->subYear()),
                'valid_until' => $document->valid_until,
                'status' => $status,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
                'deleted_at' => (DB::table('addworking_common_files')
                        ->where('id', $document->file_id)->first()->deleted_at ?? null),
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
        DB::table('addworking_enterprise_documents')->truncate();
    }
}
