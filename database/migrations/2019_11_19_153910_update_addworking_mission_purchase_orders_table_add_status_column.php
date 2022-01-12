<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionPurchaseOrdersTableAddStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_purchase_orders', function (Blueprint $table) {
            $table->string('status')->default('draft');
        });

        $orders = DB::table('addworking_mission_purchase_orders')->get();

        foreach ($orders as $order) {
            DB::table('addworking_mission_purchase_orders')->whereId($order->id)->update([
                'status' => "draft",
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
        Schema::table('addworking_mission_purchase_orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
