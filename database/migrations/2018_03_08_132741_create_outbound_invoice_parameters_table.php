<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboundInvoiceParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_invoice_parameters', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->float('management_fees')->default(.05)->comment('percentage');
            $table->float('fixed_fees')->default(15)->comment('amountt');
            $table->datetime('trial_ends_at')->default('2018-01-01');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });

        $data = [
            "STARS SERVICE" => [
                "management_fees" => .02,
                "fixed_fees" => 10,
                "trial_ends_at" => "2018-01-31"
            ],
            "TSE EXPRESS MEDICAL" => [
                "management_fees" => .02,
                "fixed_fees" => 10,
                "trial_ends_at" => "2018-01-31"
            ],
            "GCS EUROPE" => [
                "management_fees" => .04,
                "fixed_fees" => 0,
                "trial_ends_at" => "2018-01-31"
            ],
            "COURSIER.FR" => [
                "management_fees" => .011,
                "fixed_fees" => 0,
                "trial_ends_at" => "2018-05-31"
            ],
        ];

        foreach ($data as $name => $params) {
            if ($enterprise_id = DB::table('enterprises')->select('id')->whereName($name)->value('id')) {
                $id = Uuid::generate(4);
                DB::table('outbound_invoice_parameters')->insert(@compact('id', 'enterprise_id') + $params);
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
        Schema::dropIfExists('outbound_invoice_parameters');
    }
}
