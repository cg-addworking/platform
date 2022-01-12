<?php

use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Models\Addworking\Enterprise\Enterprise;

class UpdateAddworkingEntrepriseInvoiceParametersTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->boolean('invoicing_from_inbound_invoice')->default(false);
        });

        $sogetrel = Enterprise::where('name', 'SOGETREL')->first();
        if (!is_null($sogetrel)) {
            $family = App::make(FamilyEnterpriseRepository::class)->getFamily($sogetrel);

            foreach ($family as $enterprise) {
                $invoice_parameter = InvoiceParameter::whereHas('enterprise', function ($query) use ($enterprise) {
                    $query->where('id', $enterprise->id);
                })->isActive()->latest()->first();

                if (!is_null($invoice_parameter)) {
                    $invoice_parameter->update(['invoicing_from_inbound_invoice' => true]);
                }
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
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dropColumn(['invoicing_from_inbound_invoice']);
        });
    }
}
