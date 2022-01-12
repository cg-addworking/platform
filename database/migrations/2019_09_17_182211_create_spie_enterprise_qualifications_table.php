<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpieEnterpriseQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spie_enterprise_qualifications', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('display_name')->nullable();
            $table->boolean('follow_up')->nullable();
            $table->boolean('active')->nullable();
            $table->date('valid_until')->nullable();
            $table->date('revived_at')->nullable();
            $table->string('site')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('enterprise_id')
                ->references('id')->on('spie_enterprise_enterprises')
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
        Schema::dropIfExists('spie_enterprise_qualifications');
    }
}
