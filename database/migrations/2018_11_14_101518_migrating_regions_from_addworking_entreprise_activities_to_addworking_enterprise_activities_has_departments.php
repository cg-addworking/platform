<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigratingRegionsFromAddworkingEntrepriseActivitiesToAddworkingEnterpriseActivitiesHasDepartments extends Migration
{
    protected $departments = [
        '0' => 'Ain',
        '1' => 'Aisne',
        '2' => 'Allier',
        '3' => 'Alpes de Haute Provence',
        '4' => 'Hautes Alpes',
        '5' => 'Alpes Maritimes',
        '6' => 'Ardèche',
        '7' => 'Ardennes',
        '8' => 'Ariège',
        '9' => 'Aube',
        '10' => 'Aude',
        '11' => 'Aveyron',
        '12' => 'Bouches du Rhône',
        '13' => 'Calvados',
        '14' => 'Cantal',
        '15' => 'Charente',
        '16' => 'Charente Maritime',
        '17' => 'Cher',
        '18' => 'Corrèze',
        '19' => 'Corse du Sud',
        '20' => 'Haute Corse',
        '21' => 'Côte d\'Or',
        '22' => 'Côtes d\'Armor',
        '23' => 'Creuse',
        '24' => 'Dordogne',
        '25' => 'Doubs',
        '26' => 'Drôme',
        '27' => 'Eure',
        '28' => 'Eure et Loir',
        '29' => 'Finistère',
        '30' => 'Gard',
        '31' => 'Haute Garonne',
        '32' => 'Gers',
        '33' => 'Gironde',
        '34' => 'Hérault',
        '35' => 'Ille et Vilaine',
        '36' => 'Indre',
        '37' => 'Indre et Loire',
        '38' => 'Isère',
        '39' => 'Jura',
        '40' => 'Landes',
        '41' => 'Loir et Cher',
        '42' => 'Loire',
        '43' => 'Haute Loire',
        '44' => 'Loire Atlantique',
        '45' => 'Loiret',
        '46' => 'Lot',
        '47' => 'Lot et Garonne',
        '48' => 'Lozère',
        '49' => 'Maine et Loire',
        '50' => 'Manche',
        '51' => 'Marne',
        '52' => 'Haute Marne',
        '53' => 'Mayenne',
        '54' => 'Meurthe et Moselle',
        '55' => 'Meuse',
        '56' => 'Morbihan',
        '57' => 'Moselle',
        '58' => 'Nièvre',
        '59' => 'Nord',
        '60' => 'Oise',
        '61' => 'Orne',
        '62' => 'Pas de Calais',
        '63' => 'Puy de Dôme',
        '64' => 'Pyrénées Atlantiques',
        '65' => 'Hautes Pyrénées',
        '66' => 'Pyrénées Orientales',
        '67' => 'Bas Rhin',
        '68' => 'Haut Rhin',
        '69' => 'Rhône',
        '70' => 'Haute Saône',
        '71' => 'Saône et Loire',
        '72' => 'Sarthe',
        '73' => 'Savoie',
        '74' => 'Haute Savoie',
        '75' => 'Paris',
        '76' => 'Seine Maritime',
        '77' => 'Seine et Marne',
        '78' => 'Yvelines',
        '79' => 'Deux Sèvres',
        '80' => 'Somme',
        '81' => 'Tarn',
        '82' => 'Tarn et Garonne',
        '83' => 'Var',
        '84' => 'Vaucluse',
        '85' => 'Vendée',
        '86' => 'Vienne',
        '87' => 'Haute Vienne',
        '88' => 'Vosges',
        '89' => 'Yonne',
        '90' => 'Territoire de Belfort',
        '91' => 'Essonne',
        '92' => 'Hauts de Seine',
        '93' => 'Seine St Denis',
        '94' => 'Val de Marne',
        '95' => 'Val d\'Oise',
        '96' => 'DOM',
        '97' => 'Guadeloupe',
        '98' => 'Martinique',
        '99' => 'Guyane',
        '100' => 'Réunion',
        '101' => 'Mayotte',
    ];

    /**
     * correspondence between old and new departments
     */
    protected $regionsMapping = [
        "Alsace" => "Grand Est",
        "Champagne-Ardenne" => "Grand Est",
        "Lorraine" => "Grand Est",
        "Aquitaine" => "Nouvelle-Aquitaine",
        "Limousin" => "Nouvelle-Aquitaine",
        "Poitou-Charentes" => "Nouvelle-Aquitaine",
        "Auvergne" => "Auvergne-Rhône-Alpes",
        "Rhône-Alpes" => "Auvergne-Rhône-Alpes",
        "Basse-Normandie"  => "Normandie",
        "Haute-Normandie" => "Normandie",
        "Bourgogne" => "Bourgogne-Franche-Comté",
        "Franche-Comté" => "Bourgogne-Franche-Comté",
        "Bretagne" => "Bretagne",
        "Centre" => "Centre-Val de Loire",
        "Corse" => "Corse",
        "Martinique" => "Départements d'Outre-Mer",
        "Mayotte" => "Départements d'Outre-Mer",
        "Guadeloupe" => "Départements d'Outre-Mer",
        "Guyane" => "Départements d'Outre-Mer",
        "La Réunion" => "Départements d'Outre-Mer",
        "Île-de-France" => "Île-de-France",
        "Languedoc-Roussillon" => "Occitanie",
        "Midi-Pyrénées" => "Occitanie",
        "Nord-Pas-de-Calais" => "Hauts-de-France",
        "Picardie" => "Hauts-de-France",
        "Pays de la Loire" => "Pays de la Loire",
        "Provence-Alpes-Côte d'Azur" => "Provence-Alpes-Côte-d'Azur",
        "Territoires d'Outre-Mer" => "Territoires d'Outre-Mer"
    ];

    protected function getDepartmentsFromSearch($result, $activity)
    {
        $department = DB::table('addworking_common_departments')
                ->where('display_name', $result)
                ->first();

        if ($department) {
            DB::table('addworking_enterprise_activities_has_departments')->insert(
                ['activity_id' => $activity->id, 'department_id' => $department->id]
            );
        } else {
            $region = DB::table('addworking_common_regions')
                ->where('display_name', $result)
                ->first();

            if ($region) {
                $departments = DB::table('addworking_common_departments')
                    ->where('region_id', $region->id)
                    ->get();

                foreach ($departments as $department) {
                    DB::table('addworking_enterprise_activities_has_departments')->insert(
                        ['activity_id' => $activity->id, 'department_id' => $department->id]
                    );
                }
            }
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $activities = DB::table('addworking_enterprise_activities')->get();

        $europe = array_flatten(config('regions.Europe'));
        $others = array_flatten(config('regions.Autres pays'));
        $countries = array_merge($europe, $others);

        foreach ($countries as $localisation) {
            $localisations_ngrams[$localisation] = ngram(strtolower($localisation));
        }

        $regions = DB::table('addworking_common_regions')->get();
        $departments = DB::table('addworking_common_departments')->get();
        $departmentsAndRegions = array_merge($regions->toArray(), $departments->toArray());

        foreach ($departmentsAndRegions as $localisation) {
            $localisations_ngrams[$localisation->display_name] = ngram(strtolower($localisation->display_name));
        }

        foreach ($activities as $activity) {
            // If it's a number, we search the corresponding department
            if (is_numeric($activity->region) && isset($this->departments[$activity->region])) {
                $activity->region = $this->departments[$activity->region];
            }

            // If it's an old region, search for the new correspmondante region
            if (isset($this->regionsMapping[$activity->region])) {
                $activity->region = $this->regionsMapping[$activity->region];
            }

            $search_result = find_closest($localisations_ngrams, $activity->region);
            $this->getDepartmentsFromSearch($search_result, $activity);
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
