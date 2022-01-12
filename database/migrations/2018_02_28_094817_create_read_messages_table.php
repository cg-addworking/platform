<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class createReadMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('read_messages', function (Blueprint $table) {
            $table->uuid('chat_message_id');
            $table->uuid('user_id');
            $table->datetime('read_at')->nullable();
            $table->timestamps();
            $table->primary(['chat_message_id', 'user_id']);
            $table->foreign('chat_message_id')->references('id')->on('chat_messages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('read_messages');
    }
}
