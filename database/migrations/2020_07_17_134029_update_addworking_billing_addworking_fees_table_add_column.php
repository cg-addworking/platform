<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingAddworkingFeesTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->integer('number')->default(0);
        });

        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->boolean('is_canceled')->default(false);
        });

        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable();

            $table
                ->foreign('parent_id')
                ->references('id')
                ->on('addworking_billing_addworking_fees')
                ->onDelete('set null');
        });

        $fees = DB::table('addworking_billing_addworking_fees')->get();
        $num = 0;

        foreach ($fees as $fee) {
            $num ++;

            DB::table('addworking_billing_addworking_fees')
                ->where('id', $fee->id)
                ->update(['number' => $num]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->dropColumn('number');
        });

        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });

        Schema::table('addworking_billing_addworking_fees', function (Blueprint $table) {
            $table->dropColumn('is_canceled');
        });
    }
}
