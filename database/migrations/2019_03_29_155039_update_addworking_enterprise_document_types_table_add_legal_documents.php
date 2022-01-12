<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class UpdateAddworkingEnterpriseDocumentTypesTableAddLegalDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enterprise = DB::table('addworking_enterprise_enterprises')
            ->select('id')
            ->where('name', 'ADDWORKING')
            ->first();

        if ($enterprise) {
            DB::table('addworking_enterprise_document_types')->insert([
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_establishment",
                    "display_name" => "Attestation de création d'entreprise",
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 90,
                    "document_model_id" => null,
                    "code" => "DL1_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "id_card",
                    "display_name" => "Pièce d'identité",
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DL7_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_payment_social_contribution",
                    "display_name" => "Attestation de paiement des cotisations sociales",
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 180,
                    "document_model_id" => null,
                    "code" => "DL2_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_tax_regularity",
                    "display_name" => 'Attestation de Régularité Fiscale',
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 180,
                    "document_model_id" => null,
                    "code" => "DL3_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_employment",
                    "display_name" => "Attestation d'emploi de salarié(s)",
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 180,
                    "document_model_id" => null,
                    "code" => "DL5_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_professionnal_liability",
                    "display_name" => "Attestation de Responsabilité Civile Professionnelle",
                    "description" => null,
                    "is_mandatory" => true,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DL4_V0",
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_employee_outside_the_eu",
                    "display_name" => "Attestation d'employé(s) hors Union Européenne",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => null,
                    "type" => "legal",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
            ]);

            $cpsc = DB::table('addworking_enterprise_document_types')
                ->select('id')
                ->where('name', 'certificate_of_payment_social_contribution')
                ->first();

            DB::table('addworking_enterprise_document_type_fields')->insert([
                [
                    'id' => Uuid::generate(4),
                    'type_id' => $cpsc->id,
                    'name' => "key_certificate_of_payment_social_contribution",
                    'display_name' => "Clé de vérification",
                    'help_text' => null,
                    'is_mandatory' => true,
                    'input_type' => 'text',
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]
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
        DB::table('addworking_enterprise_document_types')->truncate();
    }
}
