<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterprisesAddTemporaryColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->boolean('temporary')->default(false)->after('type');
        });

        $ids = DB::table('customer_sogetrel_passwork')->pluck('enterprise_id')->toArray();

        DB::table('enterprises')->whereIn('id', $ids)->update(['temporary' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('temporary');
        });
    }
}
