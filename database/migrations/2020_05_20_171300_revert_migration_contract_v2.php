<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevertMigrationContractV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        require_once database_path('migrations/2020_04_22_140841_contract_v2.php');

        (new ContractV2)->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        require_once database_path('migrations/2020_04_22_140841_contract_v2.php');

        (new ContractV2)->up();
    }
}
