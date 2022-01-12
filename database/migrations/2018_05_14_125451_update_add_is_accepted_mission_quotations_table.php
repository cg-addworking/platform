<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddIsAcceptedMissionQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->boolean('is_accepted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mission_quotations', 'is_accepted')) {
            Schema::table('mission_quotations', function (Blueprint $table) {
                $table->dropColumn('is_accepted');
            });
        }
    }
}
