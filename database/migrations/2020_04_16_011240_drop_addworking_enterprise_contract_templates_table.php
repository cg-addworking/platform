<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAddworkingEnterpriseContractTemplatesTable extends Migration
{
    public function up()
    {
        require_once database_path(
            "migrations/2018_11_09_172000_create_addworking_enterprise_contract_templates_table.php"
        );

        app(CreateAddworkingEnterpriseContractTemplatesTable::class)->down();
    }

    public function down()
    {
        require_once database_path(
            "migrations/2018_11_09_172000_create_addworking_enterprise_contract_templates_table.php"
        );

        app(CreateAddworkingEnterpriseContractTemplatesTable::class)->up();
    }
}
