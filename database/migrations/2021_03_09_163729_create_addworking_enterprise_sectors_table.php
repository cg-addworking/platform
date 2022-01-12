<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class CreateAddworkingEnterpriseSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_sectors', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->string('name');
            $table->string('display_name');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
        });

        $data = [
            [
                'id' => (string) Uuid::generate(4),
                'number' => 1,
                'name' => 'construction',
                'display_name' => 'Construction',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => (string) Uuid::generate(4),
                'number' => 2,
                'name' => 'transport',
                'display_name' => 'Transport',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => (string) Uuid::generate(4),
                'number' => 3,
                'name' => 'it',
                'display_name' => 'IT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('addworking_enterprise_sectors')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_sectors');
    }
}
