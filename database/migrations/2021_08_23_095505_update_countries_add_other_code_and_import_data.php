<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class UpdateCountriesAddOtherCodeAndImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'companies'.DIRECTORY_SEPARATOR.'countries.csv');

        $import_file = new SymfonyFile($path);

        $file_handle = fopen($import_file, 'r');
        $short_id = 1;
        while (!feof($file_handle)) {
            $datum = fgetcsv($file_handle, 0, ';');
            if ($datum && !in_array('other_code', $datum)) {
                $data[] = [
                    'id' => Uuid::generate(4),
                    'code' => $datum[0],
                    'other_code' => $datum[1],
                    'short_id' => $short_id,
                ];
                $short_id++;
            }
        }
        fclose($file_handle);

        Schema::table('countries', function (Blueprint $table) {
            $table->string('other_code')->nullable();
        });

        DB::table('countries')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('other_code');
            DB::table('countries')->truncate();
        });
    }
}
