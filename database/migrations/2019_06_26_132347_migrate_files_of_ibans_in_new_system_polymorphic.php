<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateFilesOfIbansInNewSystemPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ibans = DB::table('addworking_enterprise_ibans')->select('id', 'file_id')->get();

        foreach ($ibans as $iban) {
            if ($iban->file_id) {
                DB::table('addworking_common_files')->where('id', $iban->file_id)->update([
                    'attachable_id'   => $iban->id,
                    'attachable_type' => "App\Models\Addworking\Enterprise\Iban"
                ]);
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
        $ibans = DB::table('addworking_enterprise_ibans')->select('id', 'file_id')->get();

        foreach ($ibans as $iban) {
            if ($iban->file_id) {
                DB::table('addworking_common_files')->where('id', $iban->file_id)->update([
                    'attachable_id'   => null,
                    'attachable_type' => null
                ]);
            }
        }
    }
}
