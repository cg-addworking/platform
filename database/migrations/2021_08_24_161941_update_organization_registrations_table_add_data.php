<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateOrganizationRegistrationsTableAddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'companies'.DIRECTORY_SEPARATOR.'liste-des-greffes.csv');

        $import_file = new SymfonyFile($path);

        $file = fopen($import_file, 'r');

        $short_id = 1;

        while (! feof($file)) {
            $data = fgetcsv($file, 0, ';');

            if ($data) {
                $country_id = DB::table('countries')->where('code', $data[4])->first()->id;

                $items[] = [
                    'id' => Uuid::generate(4),
                    'short_id' => $short_id,
                    'country_id' => $country_id,
                    'name' => $data[0],
                    'acronym' => $data[1],
                    'location' => $data[2],
                    'code' => $data[3],
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $short_id++;
            }
        }

        fclose($file);

        Schema::table('registration_organizations', function (Blueprint $table) {
            $table->string('code')->nullable();
        });

        DB::table('registration_organizations')->insert($items);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('registration_organizations')->truncate();

        Schema::table('registration_organizations', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
