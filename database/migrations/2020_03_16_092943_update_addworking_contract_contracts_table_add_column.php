<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class UpdateAddworkingContractContractsTableAddColumn extends Migration
{
    public function up()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->uuid('contract_template_id')->nullable();

            $table
                ->foreign('contract_template_id')
                ->references('id')
                ->on('addworking_contract_contract_templates')
                ->onDelete('set null');
        });

        $this->addworking = DB::table('addworking_enterprise_enterprises')
            ->where('name', '=', 'ADDWORKING')
            ->first();

        if (is_null($this->addworking)) {
            return;
        }

        $this->updateContracs('cps1', $this->addworking->id);
        $this->updateContracs('cps2', $this->addworking->id);

        $customers = DB::table('addworking_enterprise_enterprises')
            ->where('is_customer', '=', true)
            ->get();

        foreach ($customers as $customer) {
            $this->updateContracs('cps3', $customer->id, true);
        }
    }

    public function down()
    {
        Schema::table('addworking_contract_contracts', function (Blueprint $table) {
            $table->dropColumn('contract_template_id');
        });
    }

    protected function updateContracs($type, $enterprise_id, $is_customer = false)
    {
        $template = DB::table('addworking_contract_contract_templates')
            ->where('name', '=', $type)
            ->where('enterprise_id', '=', $enterprise_id)
            ->first();

        if (is_null($template)) {
            Log::debug(vsprintf("no template found for type:%s enterprise:%s", [
                $type, $enterprise_id
            ]));

            return false;
        }

        $updated = DB::table('addworking_contract_contracts')
            ->where('type', '=', $type)
            ->when($is_customer, fn($q) => $q->where('customer_id', '=', $enterprise_id))
            ->update(['contract_template_id' => $template->id]);

        Log::debug(vsprintf("%d %s:contracts updated (enterprise:%s)", [
            $updated, $type, $enterprise_id,
        ]));

        return $updated;
    }
}
