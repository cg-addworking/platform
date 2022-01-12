<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContractSubcontractingDeclarationTableAddFileColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_subcontracting_declaration', function (Blueprint $table) {
            $table->uuid('file_id')->nullable();

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_subcontracting_declaration', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });
    }
}
