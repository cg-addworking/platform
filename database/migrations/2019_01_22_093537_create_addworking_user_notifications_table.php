<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateAddworkingUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_user_notification_preferences', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id')->unique();
            $table->boolean('email_enabled')->default(true);
            $table->boolean('confirmation_vendors_are_paid')->default(true);
            $table->timestamps();
            $table->primary('id');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('cascade');
        });


        foreach (DB::table('addworking_user_users')->select('id')->get() as $user) {
            DB::table('addworking_user_notification_preferences')->insert([
                'id' => Str::uuid(),
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_user_notification_preferences');
    }
}
