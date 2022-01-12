<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('region_id');
            $table->string('insee_code')->unique();
            $table->string('slug_name')->unique();
            $table->string('display_name');
            $table->string('prefecture');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });

        $regions = json_decode(file_get_contents(storage_path('app/regions.json')), true);

        foreach ($regions as $region) {
            $region_id = DB::table('regions')->whereSlugName($region['slug_name'])->first()->id;

            foreach ($region['departments'] as $department) {
                DB::table('departments')->insert([
                    'id'           => (string) Str::uuid(),
                    'region_id'    => $region_id,
                    'insee_code'   => $department['insee_code'],
                    'slug_name'    => $department['slug_name'],
                    'display_name' => $department['display_name'],
                    'prefecture'   => $department['prefecture'],
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now(),
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
        Schema::dropIfExists('departments');
    }
}
