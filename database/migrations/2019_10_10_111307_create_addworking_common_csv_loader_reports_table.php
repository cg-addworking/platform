<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonCsvLoaderReportsTable extends Migration
{
    public function up()
    {
        Schema::create('addworking_common_csv_loader_reports', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('label');
            $table->text('data');
            $table->integer('line_count');
            $table->integer('error_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addworking_common_csv_loader_reports');
    }
}
