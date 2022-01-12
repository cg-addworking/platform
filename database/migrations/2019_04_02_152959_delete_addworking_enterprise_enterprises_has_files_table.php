<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAddworkingEnterpriseEnterprisesHasFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('addworking_enterprise_enterprises_has_files')->truncate();

        Schema::dropIfExists('addworking_enterprise_enterprises_has_files');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_enterprise_enterprises_has_files', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('file_id');
            $table->string('type');
            $table->date('date')->nullable();
            $table->string('key')->nullable();
            $table->string('status')->default('pending_validation');
            $table->timestamps();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('jem')->nullable();
            $table->string('license_number')->nullable();
            $table->json('extra_fields')->nullable();
            $table->softDeletes();
            $table->primary(['file_id', 'enterprise_id']);

            $table->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('cascade');
            
            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }
}
