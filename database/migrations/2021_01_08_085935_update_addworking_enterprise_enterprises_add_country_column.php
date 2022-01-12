<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesAddCountryColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->string('country')->nullable();
        });

        $enterprises = DB::table('addworking_enterprise_enterprises')->orderBy('created_at', 'ASC')->get();

        foreach ($enterprises as $enterprise) {
            DB::table('addworking_enterprise_enterprises')
                ->where('id', $enterprise->id)
                ->update(['country' => 'fr']);
        }

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->string('country')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
}
