<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRevisionsTableChangeRevisionableIdType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revisions', function ($table) {
            $table->uuid('revisionable_id_copy')->nullable();
            $table->uuid('user_id_copy')->nullable();
        });

        Schema::table('revisions', function ($table) {
            $table->dropColumn('revisionable_id');
        });

        Schema::table('revisions', function ($table) {
            $table->dropColumn('user_id');
        });

        Schema::table('revisions', function ($table) {
            $table->renameColumn('revisionable_id_copy', 'revisionable_id');
        });

        Schema::table('revisions', function ($table) {
            $table->renameColumn('user_id_copy', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
