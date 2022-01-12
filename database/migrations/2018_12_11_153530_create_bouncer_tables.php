<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBouncerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_user_abilities', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->uuid('entity_id')->nullable();
            $table->string('entity_type')->nullable();
            $table->boolean('only_owned')->default(false);
            $table->json('options')->nullable();
            $table->uuid('scope')->nullable()->index();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('addworking_user_roles', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('title')->nullable();
            $table->integer('level')->unsigned()->nullable();
            $table->uuid('scope')->nullable()->index();
            $table->timestamps();
            $table->primary('id');

            $table->unique(
                ['name', 'scope'],
                'bouncer_roles_name_unique'
            );
        });

        Schema::create('addworking_user_assigned_roles', function (Blueprint $table) {
            $table->uuid('role_id')->index();
            $table->uuid('entity_id');
            $table->string('entity_type');
            $table->uuid('restricted_to_id')->nullable();
            $table->string('restricted_to_type')->nullable();
            $table->uuid('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'assigned_roles_entity_index'
            );

            $table->foreign('role_id')
                  ->references('id')->on('addworking_user_roles')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('addworking_user_permissions', function (Blueprint $table) {
            $table->uuid('ability_id')->index();
            $table->uuid('entity_id');
            $table->string('entity_type');
            $table->boolean('forbidden')->default(false);
            $table->uuid('scope')->nullable()->index();

            $table->index(
                ['entity_id', 'entity_type', 'scope'],
                'permissions_entity_index'
            );

            $table->foreign('ability_id')
                  ->references('id')->on('addworking_user_abilities')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_user_permissions');
        Schema::dropIfExists('addworking_user_assigned_roles');
        Schema::dropIfExists('addworking_user_roles');
        Schema::dropIfExists('addworking_user_abilities');
    }
}
