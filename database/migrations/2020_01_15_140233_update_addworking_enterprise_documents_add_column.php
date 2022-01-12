<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseDocumentsAddColumn extends Migration
{
    public function up()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->datetime('last_notified_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('addworking_enterprise_documents', function (Blueprint $table) {
            $table->dropColumn('last_notified_at');
        });
    }
}
