<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseDocumentTypesHasLegalForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_document_types_has_legal_forms', function (Blueprint $table) {
            $table->uuid('legal_form_id');
            $table->uuid('document_type_id');
            $table->timestamps();

            $table->primary(['legal_form_id', 'document_type_id']);

            $table->foreign('legal_form_id')
                ->references('id')->on('addworking_enterprise_legal_forms')
                ->onDelete('cascade');

            $table->foreign('document_type_id')
                ->references('id')->on('addworking_enterprise_document_types')
                ->onDelete('cascade');
        });
        
        $legal_forms = DB::table('addworking_enterprise_legal_forms')->get();
        $document_types = DB::table('addworking_enterprise_document_types')->get();

        foreach ($document_types as $document) {
            foreach ($legal_forms as $legal_form) {
                if ($document->name == "id_card" && !in_array($legal_form->name, ['ei', 'micro'])) {
                    continue;
                }

                DB::table('addworking_enterprise_document_types_has_legal_forms')->insert([
                    'legal_form_id'    => $legal_form->id,
                    'document_type_id' => $document->id,
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_document_types_has_legal_forms');
    }
}
