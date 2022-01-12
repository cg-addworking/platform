<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');
            $table->uuid('vendor_id');
            $table->uuid('user_id');
            $table->date('date');
            $table->integer('amount')->default(1);
            $table->float('unit_price')->default(0);
            $table->string('unit')->default(App\Models\Addworking\Mission\Mission::UNIT_DAYS);
            $table->string('status')->default('to_pay');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('customer_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
}
