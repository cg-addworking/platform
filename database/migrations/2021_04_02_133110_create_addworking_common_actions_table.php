<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingCommonActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_actions', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->nullable();
            $table->text('message');
            $table->string('name');
            $table->string('display_name');
            $table->uuid('trackable_id')->unsigned();
            $table->string('trackable_type');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('user_id')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_common_actions');
    }
}
