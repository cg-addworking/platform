<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingContractContractPartsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->string('signature_mention')->nullable();
            $table->integer('signature_page')->nullable();
            $table->boolean('is_signed')->default(false);
        });

        $parts = DB::table('addworking_contract_contract_parts')
            ->whereNotNull('contract_model_part_id')
            ->orderBy('created_at', 'ASC')
            ->cursor();

        foreach ($parts as $part) {
            $model =  DB::table('addworking_contract_contract_model_parts')
                ->where('id', $part->contract_model_part_id)
                ->first();

            DB::table('addworking_contract_contract_parts')
                ->update([
                    'signature_mention' => $model->signature_mention,
                    'signature_page' => $model->signature_page,
                    'is_signed' => $model->is_signed
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
        Schema::table('addworking_contract_contract_parts', function (Blueprint $table) {
            $table->dropColumn([
                'signature_mention',
                'signature_page',
                'is_signed'
            ]);
        });
    }
}
