<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerSogetrelPassworksChangeEnterpriseIdToUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->uuid('user_id')->unique()->nullable();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        $map = DB::table('customer_sogetrel_passwork')
            ->join('enterprises', 'enterprises.id', '=', 'customer_sogetrel_passwork.enterprise_id')
            ->join('enterprise_user', 'enterprise_user.enterprise_id', '=', 'enterprises.id')
            ->join('users', 'users.id', '=', 'enterprise_user.user_id')
            ->join('roles', 'roles.id', '=', 'enterprise_user.role_id')
            ->where('roles.name', 'owner')
            ->select('enterprises.id as enterprise_id', 'users.id as user_id')
            ->get()
            ->unique('user_id');

        foreach ($map as $row) {
            DB::table('customer_sogetrel_passwork')
                ->where('enterprise_id', $row->enterprise_id)
                ->update(['user_id' => $row->user_id]);
        }

        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('enterprise_id')
                ->references('id')->on('enterprises')
                ->onDelete('cascade');
        });

        $map = DB::table('customer_sogetrel_passwork')
            ->join('users', 'users.id', '=', 'customer_sogetrel_passwork.user_id')
            ->join('enterprise_user', 'enterprise_user.user_id', '=', 'users.id')
            ->join('enterprises', 'enterprises.id', '=', 'enterprise_user.enterprise_id')
            ->join('roles', 'roles.id', '=', 'enterprise_user.role_id')
            ->where('roles.name', 'owner')
            ->select('enterprises.id as enterprise_id', 'users.id as user_id')
            ->get();

        foreach ($map as $row) {
            DB::table('customer_sogetrel_passwork')
                ->where('user_id', $row->user_id)
                ->update(['enterprise_id' => $row->enterprise_id]);
        }

        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
