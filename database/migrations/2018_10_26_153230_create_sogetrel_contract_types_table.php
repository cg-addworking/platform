<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\HasUuid;

class CreateSogetrelContractTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_contract_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name')->unique();
            $table->string('display_name');
            $table->timestamps();
        });

        $types = ['GENERIC', 'ICTR', 'RIP', 'BE RIP', 'ENEDIS', 'GAZPAR'];

        foreach ($types as $type) {
            $id = (new class {
                use HasUuid;
                protected $uuidVersion = 5;
                protected $uuidNode = ':name';
            });

            $id->name = $type;

            DB::table('sogetrel_contract_types')->insert(
                [
                    'id' => $id->getUuid(),
                    'name' => $type,
                    'display_name' => $type
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sogetrel_contract_types');
    }
}
