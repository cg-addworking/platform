<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAddworkingEnterpriseVendorDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('addworking_enterprise_vendor_documents')->truncate();

        Schema::dropIfExists('addworking_enterprise_vendor_documents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_enterprise_vendor_documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('sworn_statement')->nullable();
            $table->text('name');
            $table->text('label');
            $table->integer('validity_period')->nullable();
            $table->boolean('is_mandatory')->nullable();
            $table->boolean('required_for_billing')->nullable();
            $table->json('extra_fields')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
            
            $table->foreign('sworn_statement')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('cascade')
                ->nullable();
        });
    }
}
