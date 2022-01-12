<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSogetrelPassworksChangeDepartmentsJsonStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_sogetrel_passwork_department', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('department_id');
            $table->timestamps();
            $table->primary(['passwork_id', 'department_id']);

            $table->foreign('passwork_id')
                ->references('id')->on('customer_sogetrel_passwork')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')->on('departments')
                ->onDelete('cascade');
        });

        // structure of departments from config file at 2018-07-26
        $departments = ['Ain', 'Aisne', 'Allier', 'Alpes de Haute Provence', 'Hautes Alpes', 'Alpes Maritimes', 'Ardèche', 'Ardennes', 'Ariège', 'Aube', 'Aude', 'Aveyron', 'Bouches du Rhône', 'Calvados', 'Cantal', 'Charente', 'Charente Maritime', 'Cher', 'Corrèze', 'Corse du Sud', 'Haute Corse', 'Côte d\'Or', 'Côtes d\'Armor', 'Creuse', 'Dordogne', 'Doubs', 'Drôme', 'Eure', 'Eure et Loir', 'Finistère', 'Gard', 'Haute Garonne', 'Gers', 'Gironde', 'Hérault', 'Ille et Vilaine', 'Indre', 'Indre et Loire', 'Isère', 'Jura', 'Landes', 'Loir et Cher', 'Loire', 'Haute Loire', 'Loire Atlantique', 'Loiret', 'Lot', 'Lot et Garonne', 'Lozère', 'Maine et Loire', 'Manche', 'Marne', 'Haute Marne', 'Mayenne', 'Meurthe et Moselle', 'Meuse', 'Morbihan', 'Moselle', 'Nièvre', 'Nord', 'Oise', 'Orne', 'Pas de Calais', 'Puy de Dôme', 'Pyrénées Atlantiques', 'Hautes Pyrénées', 'Pyrénées Orientales', 'Bas Rhin', 'Haut Rhin', 'Rhône', 'Haute Saône', 'Saône et Loire', 'Sarthe', 'Savoie', 'Haute Savoie', 'Paris', 'Seine Maritime', 'Seine et Marne', 'Yvelines', 'Deux Sèvres', 'Somme', 'Tarn', 'Tarn et Garonne', 'Var', 'Vaucluse', 'Vendée', 'Vienne', 'Haute Vienne', 'Vosges', 'Yonne', 'Territoire de Belfort', 'Essonne', 'Hauts de Seine', 'Seine St Denis', 'Val de Marne', 'Val d\'Oise', 'DOM', 'Guadeloupe', 'Martinique', 'Guyane', 'Réunion', 'Saint Pierre et Miquelon', 'Mayotte'];

        $map = array_combine(
            array_map('snake_case', $departments),
            array_map('str_slug', $departments)
        );

        $ids = DB::table('departments')->pluck('id', 'slug_name');

        $inserts = DB::table('customer_sogetrel_passwork')
            ->select('id', 'data', 'created_at', 'updated_at')
            ->get()
            ->reduce(function ($carry, $passwork) use ($map, $ids, &$inserts) {
                $insert = [
                    'passwork_id' => $passwork->id,
                    'created_at'  => $passwork->created_at,
                    'updated_at'  => $passwork->updated_at,
                ];

                $data        = json_decode($passwork->data, true);
                $departments = array_get($data, 'departments', []);

                foreach ($departments as $name => $bool) {
                    if (!isset($map[$name], $ids[$map[$name]])) {
                        continue;
                    }

                    $carry[] = $insert + ['department_id' => $ids[$map[$name]]];
                }

                return $carry;
            }, []);

        DB::table('customer_sogetrel_passwork_department')->insert($inserts);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sogetrel_passwork_department');
    }
}
