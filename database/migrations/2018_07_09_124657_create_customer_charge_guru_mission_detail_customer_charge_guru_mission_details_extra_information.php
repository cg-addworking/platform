<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerChargeGuruMissionDetailCustomerChargeGuruMissionDetailsExtraInformation extends Migration
{
    protected $left  = "customer_charge_guru_mission_detail";
    protected $right = "customer_charge_guru_mission_details_extra_information";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("{$this->left}_{$this->right}", function (Blueprint $table) {
            $table->uuid('mission_detail_id');
            $table->uuid('mission_detail_extra_information_id');
            $table->timestamps();

            $table->primary([
                'mission_detail_id',
                'mission_detail_extra_information_id'
            ], 'pk_id_extra_information_id');

            $table
                ->foreign('mission_detail_id', 'fk_mission_detail_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details')
                ->onDelete('cascade');

            $table
                ->foreign('mission_detail_extra_information_id', 'fk_mission_detail_extra_information_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_extra_informations')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->left}_{$this->right}");
    }
}
