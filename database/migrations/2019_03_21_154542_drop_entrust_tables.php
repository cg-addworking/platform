<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropEntrustTables extends Migration
{
    /**
     * Constructor
     */
    public function __construct()
    {
        require_once __DIR__ . "/2017_09_06_152534_entrust_setup_tables.php";
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new EntrustSetupTables)->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new EntrustSetupTables)->up();
    }
}
