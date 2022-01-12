<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprise_member', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('user_id');
            $table->uuid('role_id')->nullable();
            $table->timestamps();
            $table->primary(['enterprise_id', 'user_id']);

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });

        $roles = DB::table('roles')->whereIn('name', ['owner', 'member', 'employee'])->pluck('id')->toArray();

        $relations = DB::table('enterprise_user')
            ->select('enterprise_id', 'user_id', 'role_id')
            ->whereIn('role_id', $roles)
            ->get();

        foreach ($relations as $relation) {
            DB::table('enterprise_member')->insert((array) $relation);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_member');
    }
}
