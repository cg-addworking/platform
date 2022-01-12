<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateTaggingTagged extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('tagging_tagged');

        Schema::create('tagging_tagged', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('taggable_id')->index();
            $table->string('taggable_type', 125)->index();
            $table->string('tag_name', 125);
            $table->string('tag_slug', 125)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tagging_tagged');

        Schema::create('tagging_tagged', function (Blueprint $table) {
            $table->increments('id');
            if (config('tagging.primary_keys_type') == 'string') {
                $table->string('taggable_id', 36)->index();
            } else {
                $table->integer('taggable_id')->unsigned()->index();
            }
            $table->string('taggable_type', 125)->index();
            $table->string('tag_name', 125);
            $table->string('tag_slug', 125)->index();
        });
    }
}
