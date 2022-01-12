<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserLogsTableAddRequestDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_logs', function (Blueprint $table) {
            $table->ipAddress('ip')->nullable()->after('http_method');
            $table->json('input')->nullable()->after('ip');
            $table->json('headers')->nullable()->after('input');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('ip');
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('input');
        });

        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropColumn('headers');
        });
    }
}
