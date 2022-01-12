<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class UpdateCurrenciesAddCodeAndImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'companies'.DIRECTORY_SEPARATOR.'currencies.csv');

        $import_file = new SymfonyFile($path);

        $file_handle = fopen($import_file, 'r');
        $short_id = 1;
        while (!feof($file_handle)) {
            $datum = fgetcsv($file_handle, 0, ';');
            if ($datum && !in_array('acronym', $datum)) {
                $data[] = [
                    'id' => Uuid::generate(4),
                    'name' => $datum[0],
                    'acronym' => $datum[1],
                    'code' => $datum[2],
                    'short_id' => $short_id,
                ];
                $short_id++;
            }
        }
        fclose($file_handle);

        Schema::table('currencies', function (Blueprint $table) {
            $table->integer('code')->nullable();
        });

        DB::table('currencies')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('code');
            DB::table('currencies')->truncate();
        });
    }
}
