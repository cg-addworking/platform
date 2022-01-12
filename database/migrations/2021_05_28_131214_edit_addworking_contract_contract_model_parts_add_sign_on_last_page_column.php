<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingContractContractModelPartsAddSignOnLastPageColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->text('sign_on_last_page')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_model_parts', function (Blueprint $table) {
            $table->dropColumn('sign_on_last_page');
        });
    }
}
