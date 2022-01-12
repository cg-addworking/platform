<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('slug_name')->unique();
            $table->string('display_name');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
        });

        $regions = json_decode(file_get_contents(storage_path('app/regions.json')), true);

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'id'           => (string) Str::uuid(),
                'slug_name'    => $region['slug_name'],
                'display_name' => $region['display_name'],
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
