<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class UpdateAddworkingEnterpriseDocumentTypesTableAddBusinessDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enterprises = DB::table('addworking_enterprise_enterprises')
            ->select('id')
            ->where('name', 'TSE EXPRESS MEDICAL')
            ->orWhere('name', 'STARS SERVICE')
            ->get();

        foreach ($enterprises as $enterprise) {
            DB::table('addworking_enterprise_document_types')->insert([
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "certificate_of_professional_competence_in_light_goods_road_transport",
                    "display_name" => "Attestation de capacité professionnelle en transport routier léger de marchandises",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DMT1_V0",
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "authorization_practice_profession_public_transport_goods_persons_commissionaires",
                    "display_name" => "Demande d'autorisation d'exercer la profession de transport public de marchandises de personnes et de commissionnaires",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => null,
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries",
                    "display_name" => "Attestation sur l'honneur : déclaratif du nombre de véhicules utilisées pour effectuer les livraisons",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 180,
                    "document_model_id" => null,
                    "code" => "DMT4_VO",
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "transport_license",
                    "display_name" => "Licence de transport",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DMT2_VO",
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "declaration_of_employment_of_your_employees",
                    "display_name" => "Déclaration d'embauche de vos salariés (DPAE)",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => null,
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "driving_license",
                    "display_name" => "Permis de conduire",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => null,
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "identity_card_for_all_staff",
                    "display_name" => "Cartes d'identité des membres du personnel",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => null,
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "criminal_record_number_3_of_each_manager_or_co_manager",
                    "display_name" => "Casier judiciaire n°3 de chaque Gérant ou cogérant",
                    "description" => null,
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DMT7_V0",
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "name" => "n_1_certified_balance_sheet",
                    "display_name" => "Bilan N-1",
                    "description" => "Si vous effectuez plus de 50% de chiffres d'affaires avec votre client référencé sur la plateforme, merci de nous transmettre la copie de votre bilan n-1 certifié par votre comptable et certifié déposé au greffe des autorités compétentes",
                    "is_mandatory" => false,
                    "validity_period" => 365,
                    "document_model_id" => null,
                    "code" => "DMT7_V0",
                    "type" => "business",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ],
            ]);
        }

        $dls = DB::table('addworking_enterprise_document_types')
            ->select('id')
            ->where('name', 'driving_license')
            ->get();

        foreach ($dls as $dl) {
            DB::table('addworking_enterprise_document_type_fields')->insert([
                [
                    'id' => Uuid::generate(4),
                    'type_id' => $dl->id,
                    'name' => "driving_license_number",
                    'display_name' => "Numéro du permis de conduire",
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
        //
    }
}
