<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_invitations', function (Blueprint $table) {
            $table->string('contact_name')->nullable();
        });

        Schema::table('addworking_enterprise_invitations', function (Blueprint $table) {
            $table->string('contact_enterprise_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_invitations', function (Blueprint $table) {
            $table->dropColumn('contact_enterprise_name');
        });

        Schema::table('addworking_enterprise_invitations', function (Blueprint $table) {
            $table->dropColumn('contact_name');
        });
    }
}
