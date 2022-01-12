<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\HasUuid;
use Illuminate\Support\Str;

class AddDepartmentToDoSogetrel extends Migration
{
    protected $inseeCodes = [
        "SOGETREL - DIRECTION OPERATIONNELLE IDF" => [
            '75', '77', '78', '91', '92', '93', '94', '95',
        ],

        "SOGETREL - DIRECTION OPERATIONNELLE OUEST" => [
            '14', '18', '22', '27', '28', '29', '35', '36', '37', '41',
            '44', '45', '49', '50', '53', '56', '61', '72', '76', '85',
        ],

        "SOGETREL - DIRECTION OPERATIONNELLE EST" => [
            '02', '08', '10', '21', '25', '39', '51', '52', '54', '55', '57', '58',
            '59', '60', '62', '67', '68', '70', '71', '80', '88', '89', '90',
        ],

        "SOGETREL - DIRECTION OPERATIONNELLE SUD OUEST" => [
            '09', '12', '16', '17', '19', '23', '24', '31', '32', '33',
            '40', '46', '47', '48', '64', '65', '79', '81', '82', '86',
        ],

        "SOGETREL - DIRECTION OPERATIONNELLE SUD EST" => [
            '01', '03', '04', '05', '06', '07', '11', '13', '2A', '2B', '15', '26',
            '30', '34', '38', '42', '43', '63', '66', '69', '73', '74', '83', '84',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sogetrel = DB::table('addworking_enterprise_enterprises')
            ->where("name", "SOGETREL")
            ->first();

        if (!$sogetrel) {
            return;
        }

        $children = DB::table('addworking_enterprise_enterprises')
            ->where("parent_id", $sogetrel->id)
            ->get();

        foreach ($children as $child) {
            $activity_id = $this->createActivity($child);

            foreach ($this->inseeCodes[$child->name] ?? [] as $code) {
                $this->addDepartment($activity_id, $code);
            }
        }
    }

    protected function createActivity($enterprise)
    {
        DB::table('addworking_enterprise_activities')->insert([
            "id"              => $id = (string) Str::uuid(),
            "enterprise_id"   => $enterprise->id,
            "activity"        => "Construction de réseaux électriques et de télécommunications",
            "field"           => "Autre",
            "employees_count" => 0,
        ]);

        return $id;
    }

    protected function addDepartment($activity_id, $insee_code)
    {
        $department = DB::table('addworking_common_departments')
            ->where('insee_code', $insee_code)
            ->first();

        DB::table('addworking_enterprise_activities_has_departments')->insert([
            "department_id" => $department->id,
            "activity_id"   => $activity_id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sogetrel = DB::table('addworking_enterprise_enterprises')
            ->where("name", "SOGETREL")
            ->first();

        if (!$sogetrel) {
            return;
        }

        $children = DB::table('addworking_enterprise_enterprises')
            ->where("parent_id", $sogetrel->id)
            ->get();

        foreach ($children as $child) {
            $activity = DB::table('addworking_enterprise_activities')
                ->where("enterprise_id", $child->id)
                ->delete();
        }
    }
}
