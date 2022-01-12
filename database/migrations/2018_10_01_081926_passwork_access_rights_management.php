<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\HasUuid;

class PassworkAccessRightsManagement extends Migration
{
    private const SOGETREL_USERS = [
        'a865aed1-27f5-441c-b4d7-f01b83ff8a68',
        'e3ad9953-0ce6-465b-97bb-48529603a044',
        'a66c0407-be96-4860-b058-52d452bf384b',
        '81552738-a069-4ab8-8820-cf7a8d561993',
        '4884c964-b1a6-4157-933a-355bdb3f6fea',
        '6321e8a9-cfa0-435e-b50f-7880ae7a9711',
        'bd2165b1-3a39-4f68-a694-5177a1790252'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role_id = optional(DB::table('roles')->where('name', 'sogetrel_admin')->first())->id;

        foreach (self::SOGETREL_USERS as $sogetrelUser) {
            if (DB::table('users')->where('id', $sogetrelUser)->exists()) {
                DB::table('role_user')
                ->insert([
                    'user_id' => $sogetrelUser,
                    'role_id' => $role_id
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
        $role_id = optional(DB::table('roles')->where('name', 'sogetrel_admin')->first())->id;

        foreach (self::SOGETREL_USERS as $sogetrelUser) {
            if (DB::table('users')->where('id', $sogetrelUser)->exists()) {
                DB::table('role_user')
                    ->where('user_id', $sogetrelUser)
                    ->where('role_id', $role_id)
                    ->delete();
            }
        }
    }
}
