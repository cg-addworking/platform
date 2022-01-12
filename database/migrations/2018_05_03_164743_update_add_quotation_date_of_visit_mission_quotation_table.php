<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddQuotationDateOfVisitMissionQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // =========================================================================

        $dataColumnId = DB::table('mission_quotations')->get(['id', 'file_id']);

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->string('bck_id')->nullable();
        });

        foreach ($dataColumnId as $ColumnId) {
            DB::table('mission_quotations')->where('id', $ColumnId->id)->update(['bck_id' => $ColumnId->file_id]);
        }

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->dropColumn('file_id');
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->uuid('file_id')->nullable();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->dropColumn('bck_id');
        });


    // =========================================================================

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->datetime('quotation_date_of_visit')->nullable();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->string('brand')->nullable()->change();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->string('reference')->nullable()->change();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->string('tools')->nullable()->change();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->float('price')->nullable()->change();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->datetime('valid_from')->nullable()->change();
        });

        Schema::table('mission_quotations', function (Blueprint $table) {
            $table->datetime('valid_until')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mission_quotations', 'quotation_date_of_visit')) {
            Schema::table('mission_quotations', function (Blueprint $table) {
                $table->dropColumn('quotation_date_of_visit');
            });
        }
    }
}
