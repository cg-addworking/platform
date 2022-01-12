<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class CreateAddworkingEnterpriseVendorHasDeadlineTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_vendor_has_deadline_types', function (Blueprint $table) {
            $table->uuid('deadline_id');
            $table->uuid('customer_id');
            $table->uuid('vendor_id');
            $table->timestamps();

            $table->primary(['deadline_id', 'customer_id', 'vendor_id']);

            $table->foreign('deadline_id')
                ->references('id')->on('addworking_billing_deadline_types')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });

        $items = DB::table('addworking_billing_vendors_available_billing_deadlines')->get();

        foreach ($items as $item) {
            switch (true) {
                case $item->upon_receipt:
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 0)->first();

                    if (is_null($deadline)) {
                        $deadline_id = DB::table('addworking_billing_deadline_types')->insertGetId([
                            'id'           => Uuid::generate(4),
                            'name'         => "0_jour",
                            'display_name' => "0 jour",
                            'value'        => 0,
                            'created_at'   => Carbon::now(),
                            'updated_at'   => Carbon::now()
                        ]);
                    } else {
                        $deadline_id = $deadline->id;
                    }

                    break;
                case $item->{'30_days'}:
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 30)->first();

                    if (is_null($deadline)) {
                        $deadline_id = DB::table('addworking_billing_deadline_types')->insertGetId([
                            'id'           => Uuid::generate(4),
                            'name'         => "30_jours",
                            'display_name' => "30 jours",
                            'value'        => 30,
                            'created_at'   => Carbon::now(),
                            'updated_at'   => Carbon::now()
                        ]);
                    } else {
                        $deadline_id = $deadline->id;
                    }

                    break;
                case $item->{'40_days'}:
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 40)->first();

                    if (is_null($deadline)) {
                        $deadline_id = DB::table('addworking_billing_deadline_types')->insertGetId([
                            'id'           => Uuid::generate(4),
                            'name'         => "40_jours",
                            'display_name' => "40 jours",
                            'value'        => 40,
                            'created_at'   => Carbon::now(),
                            'updated_at'   => Carbon::now()
                        ]);
                    } else {
                        $deadline_id = $deadline->id;
                    }

                    break;
            }

            DB::table('addworking_enterprise_vendor_has_deadline_types')->insert([
                'deadline_id' => $deadline_id,
                'customer_id' => $item->customer_id,
                'vendor_id'   => $item->vendor_id,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
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
        Schema::dropIfExists('addworking_enterprise_vendor_has_deadline_types');
    }
}
