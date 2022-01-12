<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterpriseUserPrimaryAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('users')->get() as $user) {
            if ($enterprise = $user->enterprises()->first()) {
                $user->enterprises()->updateExistingPivot($enterprise->id, ['primary' => true]);
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
        //
    }
}
