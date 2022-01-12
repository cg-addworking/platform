<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractV2 extends Migration
{
    public function up()
    {
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->text('markdown')->default('');
        });

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('version');
        });

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('data');
        });

        Schema::create('addworking_contract_contract_template_parties', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('template_id');
            $table->string('denomination');
            $table->integer('order');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('template_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_template_variables', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('template_id');
            $table->string('name');
            $table->text('description');
            $table->string('default_Value');
            $table->boolean('required');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('template_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_template_party_document_types', function (Blueprint $table) {
            $table->uuid('party_id');
            $table->uuid('document_type_id');
            $table->boolean('mandatory');
            $table->boolean('validation_required');
            $table->uuid('validated_by');
            $table->timestamps();
            $table->primary(['party_id', 'document_type_id']);

            $table->foreign('party_id')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('cascade');

            $table->foreign('document_type_id')
                ->references('id')->on('addworking_enterprise_document_types')
                ->onDelete('cascade');

            $table->foreign('validated_by')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_template_annexes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('template_id');
            $table->uuid('file_id');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('template_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('party_id');
            $table->uuid('enterprise_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('enterprise_name')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('signed')->default(false);
            $table->datetime('signed_at')->nullable();
            $table->timestamps();
            $table->primary(['contract_id', 'party_id']);

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('party_id')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('cascade');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        Schema::create('addworking_contract_contract_annexes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->uuid('file_id');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('file_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_documents', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('party_id');
            $table->uuid('document_id');
            $table->timestamps();
            $table->primary(['contract_id', 'document_id', 'party_id']);

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('party_id')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('cascade');

            $table->foreign('document_id')
                ->references('id')->on('addworking_enterprise_documents')
                ->onDelete('cascade');
        });

        Schema::create('addworking_contract_contract_variables', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('variable_id');
            $table->string('value');
            $table->timestamps();
            $table->primary(['contract_id', 'variable_id']);

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('variable_id')
                ->references('id')->on('addworking_contract_contract_template_variables')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addworking_contract_contract_variables');
        Schema::dropIfExists('addworking_contract_contract_documents');
        Schema::dropIfExists('addworking_contract_contract_annexes');
        Schema::dropIfExists('addworking_contract_contract_parties');
        Schema::dropIfExists('addworking_contract_contract_template_annexes');
        Schema::dropIfExists('addworking_contract_contract_template_party_document_types');
        Schema::dropIfExists('addworking_contract_contract_template_variables');
        Schema::dropIfExists('addworking_contract_contract_template_parties');

        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('version')->nullable();
            $table->json('data')->nullable();
        });

        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('markdown');
        });
    }
}
