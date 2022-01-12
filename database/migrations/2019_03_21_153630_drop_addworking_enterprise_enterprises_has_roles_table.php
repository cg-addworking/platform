<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAddworkingEnterpriseEnterprisesHasRolesTable extends Migration
{
    /**
     * Constructor
     */
    public function __construct()
    {
        require_once __DIR__ . "/2017_10_06_170453_create_enterprise_role.php";
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_enterprise_enterprises_has_roles',
            'enterprise_role'
        );

        (new CreateEnterpriseRole)->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new CreateEnterpriseRole)->up();

        Schema::rename(
            'enterprise_role',
            'addworking_enterprise_enterprises_has_roles'
        );
    }
}
