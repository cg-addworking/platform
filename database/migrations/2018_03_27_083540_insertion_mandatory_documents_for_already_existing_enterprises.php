<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

class InsertionMandatoryDocumentsForAlreadyExistingEnterprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $certificate_of_payment_social_contribution[1]['type'] = "date_field";
        $certificate_of_payment_social_contribution[1]['name'] = "date_certificate_of_payment_social_contribution";
        $certificate_of_payment_social_contribution[1]['label'] = "Date d'edition";

        $certificate_of_payment_social_contribution[2]["type"] = "text_field";
        $certificate_of_payment_social_contribution[2]["name"] = "key_certificate_of_payment_social_contribution";
        $certificate_of_payment_social_contribution[2]["label"] = "Clé de vérification";

        $certificate_of_tax_regularity[1]['type'] = "date_field";
        $certificate_of_tax_regularity[1]['name'] = "date_certificate_of_tax_regularity";
        $certificate_of_tax_regularity[1]['label'] = "Date d'edition";

        $certificate_of_professionnal_liability[1]['type'] = "date_field";
        $certificate_of_professionnal_liability[1]['name'] = "date_certificate_of_professionnal_liability";
        $certificate_of_professionnal_liability[1]['label'] = "Date d'edition";

        $certificate_of_professional_competence_in_light_goods_road_transport[1]['type'] = "text_field";
        $certificate_of_professional_competence_in_light_goods_road_transport[1]['name'] = "jem_certificate_of_professional_competence_in_light_goods_road_transport";
        $certificate_of_professional_competence_in_light_goods_road_transport[1]['label'] = "jem_certificate_of_professional_competence_in_light_goods_road_transport";

        $transport_license[1]['type'] = "date_field";
        $transport_license[1]['name'] = "valid_from_transport_license";
        $transport_license[1]['label'] = "Date de début de validité";

        $transport_license[2]['type'] = "date_field";
        $transport_license[2]['name'] = "valid_until_transport_license";
        $transport_license[2]['label'] = "Date de fin de validité";

        $transport_license[3]['type'] = "text_field";
        $transport_license[3]['name'] = "license_number_transport_license";
        $transport_license[3]['label'] = "Numéro du permis de conduire";

        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[1]['type'] = "date_field";
        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[1]['name'] = "valid_from_declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries";
        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[1]['label'] = "Date de début de validité";

        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[2]['type'] = "date_field";
        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[2]['name'] = "valid_until_declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries";
        $declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries[2]['label'] = "Date de fin de validité";

        // =====================================================================

        $enterprises = DB::table('enterprises')
            ->select('id')
            ->where('name', 'ADDWORKING')
            ->get();

        foreach ($enterprises as $enterprise) {
            DB::table('enterprise_vendor_documents')->insert([
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_establishment",
                    "label" => "Attestation de création d'entreprise",
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => 3,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "id_card",
                    "label" => "Pièce d'identité",
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_payment_social_contribution",
                    "label" => "Attestation de paiement des cotisations sociales",
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($certificate_of_payment_social_contribution),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => 6,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_tax_regularity",
                    "label" => 'Attestation de Régularité Fiscale',
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($certificate_of_tax_regularity),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => 6,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_employment",
                    "label" => "Attestation d'emploi de salarié(s)",
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => 6,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_professionnal_liability",
                    "label" => "Attestation de Responsabilité Civile Professionnelle",
                    "is_mandatory" => "1",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($certificate_of_professionnal_liability),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_employee_outside_the_eu",
                    "label" => "Attestation d'employé(s) hors Union Européenne",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
            ]);
        }

        $enterprises = DB::table('enterprises')
            ->select('id')
            ->where('name', 'TSE EXPRESS MEDICAL')
            ->orWhere('name', 'STARS SERVICE')
            ->get();

        foreach ($enterprises as $enterprise) {
            DB::table('enterprise_vendor_documents')->insert([
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "certificate_of_professional_competence_in_light_goods_road_transport",
                    "label" => "Attestation de capacité professionnelle en transport routier léger de marchandises",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($certificate_of_professional_competence_in_light_goods_road_transport),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "authorization_practice_profession_public_transport_goods_persons_commissionaires",
                    "label" => "Demande d'autorisation d'exercer la profession de transport public de marchandises de personnes et de commissionnaires",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "transport_license",
                    "label" => "Licence de transport",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($transport_license),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries",
                    "label" => "Attestation sur l'honneur : déclaratif du nombre de véhicules utilisées pour effectuer les livraisons",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => json_encode($declaration_on_honor_declarative_number_vehicles_used_to_make_deliveries),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => 6,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "declaration_of_employment_of_your_employees",
                    "label" => "Déclaration d'embauche de vos salariés (DPAE)",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "driving_license",
                    "label" => "Permis de conduire",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "identity_card_for_all_staff",
                    "label" => "Cartes d'identité des membres du personnel",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "criminal_record_number_3_of_each_manager_or_co_manager",
                    "label" => "Casier judiciaire n°3 de chaque Gérant ou cogérant",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
                ],
                [
                    "id" => Uuid::generate(4),
                    "enterprise_id" => $enterprise->id,
                    "sworn_statement" => null,
                    "name" => "n_1_certified_balance_sheet",
                    "label" => "Si vous effectuez plus de 50% de chiffres d'affaires avec votre client référencé sur la plateforme, merci de nous transmettre la copie de votre bilan n-1 certifié par votre comptable et certifié déposé au greffe des autorités compétentes",
                    "is_mandatory" => "0",
                    "required_for_billing" => "0",
                    "extra_fields" => null,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "validity_period" => null,
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
