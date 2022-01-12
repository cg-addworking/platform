<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAddworkingContractContractModelsAddShouldVendorFillTheirVariablesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_models', function(Blueprint $table) {
            $table->boolean('should_vendors_fill_their_variables')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_contract_contract_models', function(Blueprint $table) {
            $table->dropColumn('should_vendors_fill_their_variables');
        });
    }
}
