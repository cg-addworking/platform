<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class CreateAddworkingEnterpriseAccountingExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_accounting_expenses', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('enterprise_id');
            $table->string('name');
            $table->string('display_name');
            $table->string('analytical_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('CASCADE');
        });

        $enterprises = DB::table('addworking_enterprise_enterprises')
            ->where('is_customer', '=', true)
            ->orderBy('created_at', 'ASC')
            ->cursor();

        $number = 1;
        foreach ($enterprises as $enterprise) {
            DB::table('addworking_enterprise_accounting_expenses')->insert([
                'id' => (string) Uuid::generate(4),
                'enterprise_id' => $enterprise->id,
                'number' => $number,
                'name' => 'prestation',
                'display_name' => 'Prestation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $number++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_accounting_expenses');
    }
}
