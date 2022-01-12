<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class MigrateFileIdToContractPart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contracts = DB::table('addworking_contract_contracts')->orderBy('created_at', 'ASC')->get();

        foreach ($contracts as $contract) {
            if (! is_null($contract->file_id)) {
                $number = DB::table('addworking_contract_contract_parts')->count();
                DB::table('addworking_contract_contract_parts')
                ->insert([
                    'id' => Uuid::generate(4),
                    'number' => $number + 1,
                    'name' => "corps_de_contrat",
                    'display_name' => "Corps de contrat",
                    'file_id' => $contract->file_id,
                    'contract_id' => $contract->id,
                    'is_hidden' => false,
                    'created_at' => $contract->created_at,
                    'updated_at' => $contract->updated_at,
                    'order' => 1,
                    'contract_model_part_id' => null
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
        //
    }
}
