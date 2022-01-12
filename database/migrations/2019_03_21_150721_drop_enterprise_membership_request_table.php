<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropEnterpriseMembershipRequestTable extends Migration
{
    /**
     * Constructor
     */
    public function __construct()
    {
        require_once __DIR__ . "/2018_06_12_151015_create_enterprise_membership_requests_table.php";
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_enterprise_membership_requests',
            'enterprise_membership_requests'
        );

        (new CreateEnterpriseMembershipRequestsTable)->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        (new CreateEnterpriseMembershipRequestsTable)->up();

        Schema::rename(
            'enterprise_membership_requests',
            'addworking_enterprise_membership_requests'
        );
    }
}
