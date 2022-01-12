<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentsAddProofAuthenticityIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->uuid('proof_authenticity_id')->nullable();

            $table->foreign('proof_authenticity_id')
                  ->references('id')
                  ->on('addworking_common_files')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
                $table->dropForeign(['proof_authenticity_id']);
            });
        }

        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->dropColumn('proof_authenticity_id');
        });
    }
}
