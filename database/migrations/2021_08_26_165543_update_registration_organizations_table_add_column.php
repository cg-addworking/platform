<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateRegistrationOrganizationsTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registration_organizations', function (Blueprint $table) {
            $table->string('location_formatted')->nullable();
        });

        $organisations = DB::table('registration_organizations')->get();
        foreach ($organisations as $organisation) {
            DB::table('registration_organizations')->where('id', $organisation->id)
                ->update(['location_formatted' => strtoupper(remove_accents($organisation->location))]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_organizations', function (Blueprint $table) {
            $table->dropColumn('location_formatted');
        });
    }
}
