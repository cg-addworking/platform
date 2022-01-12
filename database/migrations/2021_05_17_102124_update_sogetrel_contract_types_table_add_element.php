<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class UpdateSogetrelContractTypesTableAddElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_contract_types', function (Blueprint $table) {
            $table->integer('order')->nullable();
        });

        $types = [
            1 => 'ALTITUDE (D3)',
            3 => 'COVAGE (D3)',
            5 => 'KOSC (D3)',
            12 => 'RADIO',
            14 => 'VOLTALIS'
        ];

        foreach ($types as $order => $type) {
            DB::table('sogetrel_contract_types')->insert([
                'id' => Uuid::generate(4),
                'name' => str_slug($type),
                'display_name' => $type,
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s"),
                'order'        => $order
            ]);
        }

        $items = DB::table('sogetrel_contract_types')->cursor();

        foreach ($items as $item) {
            if ($item->name == 'BYTEL') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'name' => str_slug('BYTEL (D3)'),
                        'display_name' => 'BYTEL (D3)',
                        'order' => 2,
                    ]);
            }
            if ($item->name == 'FREE') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'name' => str_slug('FREE (D3)'),
                        'display_name' => 'FREE (D3)',
                        'order' => 4,
                    ]);
            }
            if ($item->name == 'ICTR') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order' => 6,
                    ]);
            }
            if ($item->name == 'SUPERSONIC') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 7,
                    ]);
            }
            if ($item->name == 'RIP') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 8,
                    ]);
            }
            if ($item->name == 'BE RIP') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 9,
                    ]);
            }
            if ($item->name == 'BOUYGUES INDUS') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 10,
                    ]);
            }
            if ($item->name == 'FTTA BOUYGTEL') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 11,
                    ]);
            }
            if ($item->name == 'ENEDIS') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 13,
                    ]);
            }
            if ($item->name == 'GAZPAR') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->update([
                        'order'=> 15,
                    ]);
            }
            if ($item->name == 'GENERIC') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->delete();
            }

            if ($item->name == 'AUTRE') {
                DB::table('sogetrel_contract_types')
                    ->where('id', $item->id)
                    ->delete();
            }
        }

        Schema::table('sogetrel_contract_types', function (Blueprint $table) {
            $table->integer('order')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_contract_types', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        DB::table('sogetrel_contract_types')
            ->where('display_name','=', 'ALTITUDE (D3)')
            ->orWhere('display_name', '=','COVAGE (D3)')
            ->orWhere('display_name', '=','KOSC (D3)')
            ->orWhere('display_name', '=','RADIO')
            ->orWhere('display_name', '=','VOLTALIS')
            ->delete();

        DB::table('sogetrel_contract_types')
            ->where('name', str_slug('BYTEL (D3)'))
            ->update([
                'name' => 'BYTEL',
                'display_name' => 'BYTEL',
            ]);

        DB::table('sogetrel_contract_types')
            ->where('name', str_slug('FREE (D3)'))
            ->update([
                'name' => 'FREE',
                'display_name' => 'FREE',
            ]);

        DB::table('sogetrel_contract_types')->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'GENERIC',
                'display_name' => 'GENERIC',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'AUTRE',
                'display_name' => 'AUTRE',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
