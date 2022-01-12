<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworkQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_quizzes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('passwork_id');
            $table->string('status')->default('pending');
            $table->string('job')->nullable();
            $table->integer('score')->nullable();
            $table->string('level')->nullable();
            $table->string('url');
            $table->date('proposed_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('passwork_id')
                ->references('id')->on('sogetrel_user_passworks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_user_passwork_quizzes');
    }
}
