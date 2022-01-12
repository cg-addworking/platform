<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Webpatser\Uuid\Uuid;

class CreateIbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibans', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('file_id')->nullable();
            $table->string('iban');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });

        $rows = DB::table('enterprises')->select('id', 'iban')->whereNotNull('iban')->get();
        $inserts = [];

        foreach ($rows as $row) {
            $inserts[] = [
                'id'                  => Uuid::generate(4),
                'enterprise_id'       => $row->id,
                'iban'                => $row->iban,
                'created_at'          => Carbon\Carbon::now(),
                'updated_at'          => Carbon\Carbon::now(),
            ];

            DB::table('enterprises')->where('id', $row->id)->update([
                'iban' => null,
            ]);
        }

        DB::table('ibans')->insert($inserts);

        Schema::disableForeignKeyConstraints();
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('iban');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('iban')->nullable();
        });

        $ibans = DB::table('ibans')->select('*')->get();
        foreach ($ibans as $iban) {
            DB::table('enterprises')->where('id', $iban->enterprise_id)->update([
                'iban' => $iban->iban,
            ]);
        }

        Schema::dropIfExists('ibans');
    }
}
