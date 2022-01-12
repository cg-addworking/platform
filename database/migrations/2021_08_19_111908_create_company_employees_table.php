<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_employees', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('company_id');
            $table->integer('number')->default(0);
            $table->integer('range')->default(0);
            $table->date('year');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_employees');
    }
}
