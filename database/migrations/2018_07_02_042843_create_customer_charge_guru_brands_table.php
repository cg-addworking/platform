<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateCustomerChargeGuruBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_brands', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('slug_name')->unique();
            $table->string('display_name');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });

        $brands = [
            'schneider'   => 'Schneider',
            'legrand'     => 'Legrand',
            'hager'       => 'Hager',
            'evbox'       => 'EVBox',
            'new_motion'  => 'New Motion',
            'g2_mobility' => 'G2 Mobility',
            'dbt'         => 'DBT',
        ];

        foreach ($brands as $slugName => $displayName) {
            DB::table('customer_charge_guru_brands')->insert([
                'id'           => (string) Str::uuid(),
                'slug_name'    => $slugName,
                'display_name' => $displayName,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
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
        Schema::dropIfExists('customer_charge_guru_brands');
    }
}
