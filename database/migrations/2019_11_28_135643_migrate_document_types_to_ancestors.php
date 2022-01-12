<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class MigrateDocumentTypesToAncestors extends Migration
{
    public function up()
    {
        if (config('app.env') != 'production') {
            return;
        }

        //Migrate {Charte RSE Sogetrel}
        $sogetrel = DB::table('addworking_enterprise_enterprises')->where('name', "SOGETREL")->first();

        $old_charte_rse_sogetrel_types = DB::table('addworking_enterprise_document_types')
            ->where('display_name', "Charte RSE Sogetrel")
            ->pluck('id');

        $new_charte_rse_sogetrel_type_id = DB::table('addworking_enterprise_document_types')->insertGetId([
            "id" => Uuid::generate(4),
            "enterprise_id" => $sogetrel->id,
            "document_model_id" => DB::table('addworking_common_files')
                ->where('id', "9c943bff-86b0-4949-a366-b41f89373597")->first()->id,
            "name" => "charte_r_s_e_sogetrel",
            "display_name" => "Charte RSE Sogetrel",
            "description" => "Charte Responsabilité Sociétale Entreprise (RSE) fournisseurs et sous-traitants",
            "is_mandatory" => true,
            "validity_period" => 365,
            "code" => "2019_SOGETREL_RSE_V1",
            "type" => "business",
            "created_at" => "2019-09-20 10:30:12",
            "updated_at" => "2019-10-02 09:05:14",
            "deleted_at" => null,
        ]);

        foreach ($old_charte_rse_sogetrel_types as $type) {
            DB::table('addworking_enterprise_documents')->where('type_id', $type)
                ->update(['type_id' => $new_charte_rse_sogetrel_type_id]);
            DB::table('addworking_enterprise_document_types')->where('id', $type)->delete();
        }

        //Migrate {Attestation caisse de congés payés}
        $soprema_agences = DB::table('addworking_enterprise_enterprises')->where('name', "SOPREMA (AGENCES)")->first();

        $old_attestation_caisse_de_conges_payes_types = DB::table('addworking_enterprise_document_types')
            ->whereIn(
                'enterprise_id',
                DB::table('addworking_enterprise_enterprises')->where('parent_id', $soprema_agences->id)->pluck('id')
            )->where('display_name', "Attestation caisse de congés payés")
            ->pluck('id');

        $new_attestation_caisse_de_conges_payes_type_id = DB::table('addworking_enterprise_document_types')
            ->insertGetId([
                "id" => Uuid::generate(4),
                "enterprise_id" => $soprema_agences->id,
                "document_model_id" => null,
                "name" => "attestation_caisse_de_conges_payes",
                "display_name" => "Attestation caisse de congés payés",
                "description" => null,
                "is_mandatory" => true,
                "validity_period" => 90,
                "code" => null,
                "type" => "legal",
                "created_at" => "2019-10-14 07:57:03",
                "updated_at" => "2019-10-14 07:57:03",
                "deleted_at" => null,
            ]);

        foreach ($old_attestation_caisse_de_conges_payes_types as $type) {
            DB::table('addworking_enterprise_documents')->where('type_id', $type)
                ->update(['type_id' => $new_attestation_caisse_de_conges_payes_type_id]);
            DB::table('addworking_enterprise_document_types')->where('id', $type)->delete();
        }

        //Migrate {Liste de références chantiers}
        $old_liste_de_references_chantiers_types = DB::table('addworking_enterprise_document_types')
            ->whereIn(
                'enterprise_id',
                DB::table('addworking_enterprise_enterprises')->where('parent_id', $soprema_agences->id)->pluck('id')
            )->where('display_name', "Liste de références chantiers")->pluck('id');

        $new_liste_de_references_chantiers_type_id = DB::table('addworking_enterprise_document_types')
            ->insertGetId([
                "id" => Uuid::generate(4),
                "enterprise_id" => $soprema_agences->id,
                "document_model_id" => null,
                "name" => "liste_de_references_chantiers",
                "display_name" => "Liste de références chantiers",
                "description" => null,
                "is_mandatory" => false,
                "validity_period" => 730,
                "code" => null,
                "type" => "business",
                "created_at" => "2019-10-14 08:02:23",
                "updated_at" => "2019-10-14 12:16:27",
                "deleted_at" => null,
            ]);

        foreach ($old_liste_de_references_chantiers_types as $type) {
            DB::table('addworking_enterprise_documents')->where('type_id', $type)
                ->update(['type_id' => $new_liste_de_references_chantiers_type_id]);
            DB::table('addworking_enterprise_document_types')->where('id', $type)->delete();
        }

        //Migrate {Attestation d'assurance décennale}
        $old_attestation_d_assurance_decennale_types = DB::table('addworking_enterprise_document_types')
            ->whereIn(
                'enterprise_id',
                DB::table('addworking_enterprise_enterprises')->where('parent_id', $soprema_agences->id)->pluck('id')
            )->where('display_name', "Attestation d'assurance décennale")->pluck('id');

        $new_attestation_d_assurance_decennale_type_id = DB::table('addworking_enterprise_document_types')
            ->insertGetId([
                "id" => Uuid::generate(4),
                "enterprise_id" => $soprema_agences->id,
                "document_model_id" => null,
                "name" => "attestation_d_assurance_decennale",
                "display_name" => "Attestation d'assurance décennale",
                "description" => "Attestation d'assurance décennale de moins de 3 mois",
                "is_mandatory" => true,
                "validity_period" => 90,
                "code" => null,
                "type" => "legal",
                "created_at" => "2019-10-14 08:01:59",
                "updated_at" => "2019-11-18 12:09:00",
                "deleted_at" => null,
             ]);

        foreach ($old_attestation_d_assurance_decennale_types as $type) {
            DB::table('addworking_enterprise_documents')->where('type_id', $type)
                ->update(['type_id' => $new_attestation_d_assurance_decennale_type_id]);
            DB::table('addworking_enterprise_document_types')->where('id', $type)->delete();
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
