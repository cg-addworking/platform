<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartAddingIsHiddenAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
}
