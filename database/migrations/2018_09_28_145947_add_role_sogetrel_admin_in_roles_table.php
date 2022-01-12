<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\HasUuid;

class AddRoleSogetrelAdminInRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $id = (new class {
            use HasUuid;
            protected $uuidVersion = 5;
            protected $uuidNode = ':name';
            protected $name = 'sogetrel_admin';
        })->getUuid();

        if (! DB::table('roles')->where('id', $id)->exists()) {
            DB::table('roles')->insert([
                'id'          => $id,
                'name'        => 'sogetrel_admin',
                'description' => "Allows to determine users sogetrel administrator"
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
        $role = DB::table('roles')
            ->where('name', 'sogetrel_admin')
            ->delete();
    }
}
