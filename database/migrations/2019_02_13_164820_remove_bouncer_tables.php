<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBouncerTables extends Migration
{
    /**
     * @var Migration
     */
    protected $migration;

    /**
     * Constructor
     */
    public function __construct()
    {
        include_once database_path('migrations/2018_12_11_153530_create_bouncer_tables.php');
        $this->migration = new CreateBouncerTables;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->migration->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->migration->up();
    }
}
