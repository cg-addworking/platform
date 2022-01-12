<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateAddworkingEnterpriseDocumentsAddSignatoryNameColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function(Blueprint $table) {
            $table->string('signatory_name')->nullable();
        });

        $signed_documents = DB::table('addworking_enterprise_documents')
            ->whereNotNull('signed_at')
            ->cursor();

        foreach ($signed_documents as $document) {
            $user = DB::table('addworking_user_users')->whereId($document->signed_by)->first();
            $user_gender = $user->gender;

            if ($user_gender == 'male') $user_gender = 'M.'; else $user_gender = 'Mme.';

            DB::table('addworking_enterprise_documents')->whereId($document->id)
                ->update(['signatory_name' => $user_gender.' '.$user->firstname.' '.$user->lastname]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_documents', function(Blueprint $table) {
            $table->dropColumn('signatory_name');
        });
    }
}
