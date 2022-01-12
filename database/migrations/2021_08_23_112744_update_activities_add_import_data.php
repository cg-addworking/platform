<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Webpatser\Uuid\Uuid;

class UpdateActivitiesAddImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'companies'.DIRECTORY_SEPARATOR.'activities.csv');

        $import_file = new SymfonyFile($path);

        $file = fopen($import_file, 'r');

        $short_id = 1;

        while (! feof($file)) {
            $data = fgetcsv($file, 0, ';');

            if ($data) {
                $sector = DB::table('addworking_enterprise_sectors')->where('name', $data[3])->first();
                $country_id = DB::table('countries')->where('code', $data[4])->first()->id;

                $items[] = [
                    'id' => Uuid::generate(4),
                    'short_id' => $short_id,
                    'code' => $data[0],     
                    'name' => $data[1],
                    'domaine' => $data[2],
                    'sector_id' => ! is_null($sector) ? $sector->id : null,
                    'country_id' =>  $country_id,
                ];
                $short_id++;
            }
        }

        fclose($file);

        DB::table('activities')->insert($items);    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('activities')->truncate();
    }
}
