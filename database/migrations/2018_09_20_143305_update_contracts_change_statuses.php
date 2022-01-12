<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractsChangeStatuses extends Migration
{
    protected $map = [
        "pending_creation" => "ready_to_generate",
        "being_created" => "generating",
        "created" => "generating",
        "ready" => "ready_to_sign",
        "signed" => "active",
        "declined" => "cancelled",
        "approved" => "active",
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->map as $key => $value) {
            DB::table('contracts')->where('status', $key)->update(['status' => $value]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (array_flip($this->map) as $key => $value) {
            DB::table('contracts')->where('status', $key)->update(['status' => $value]);
        }
    }
}
