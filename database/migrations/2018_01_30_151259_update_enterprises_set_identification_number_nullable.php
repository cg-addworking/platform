<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterprisesSetIdentificationNumberNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('identification_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $enterprises = DB::table('enterprises')
            ->select('id')
            ->whereNull('identification_number')
            ->get();


        foreach ($enterprises as $enterprise) {
            DB::table('enterprises')
                ->where('id', $enterprise->id)
                ->update(['identification_number' => random_numeric_string(14)]);
        }

        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('identification_number')->nullable(false)->change();
        });
    }
}
