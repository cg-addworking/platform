<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class CreateAddworkingContractContractTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('name');
            $table->string('display_name');
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary('id');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });

        $addworking = DB::table('addworking_enterprise_enterprises')->where('name', '=', 'ADDWORKING')->first();
    
        if (!is_null($addworking)) {
            DB::table('addworking_contract_contract_templates')->insert(
                [
                    'id'            => Uuid::generate(4),
                    'enterprise_id' => $addworking->id,
                    'name'          => 'cps1',
                    'display_name'  => 'CPS 1',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]
            );
            
            DB::table('addworking_contract_contract_templates')->insert(
                [
                    'id'            => Uuid::generate(4),
                    'enterprise_id' => $addworking->id,
                    'name'          => 'cps2',
                    'display_name'  => 'CPS 2',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]
            );
        }

        foreach (DB::table('addworking_enterprise_enterprises')->where('is_customer', '=', true)->get() as $customer) {
            DB::table('addworking_contract_contract_templates')->insert([
                'id'            => Uuid::generate(4),
                'enterprise_id' => $customer->id,
                'name'          => 'cps3',
                'display_name'  => 'CPS 3',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('addworking_contract_contract_templates');
    }
}
