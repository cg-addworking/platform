<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesAddLogoIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->uuid('logo_id')->nullable();

            $table
                ->foreign('logo_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('set null');
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
            $table->dropColumn('logo_id');
        });
    }
}
