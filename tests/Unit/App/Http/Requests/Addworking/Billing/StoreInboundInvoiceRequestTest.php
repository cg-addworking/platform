<?php

namespace Tests\Unit\App\Http\Requests\Addworking\Billing;

use App\Http\Requests\Addworking\Billing\InboundInvoice\StoreInboundInvoiceRequest;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreInboundInvoiceRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testRules()
    {
        $request         = new StoreInboundInvoiceRequest;
        $customer        = factory(Enterprise::class)->state('customer')->create();
        $inbound_invoice = factory(InboundInvoice::class)->make();

        $inputs = [
            'file'            => ['content' => $this->fakeFile('foo.pdf', 512, 'application/pdf')],
            'inbound_invoice' => [
                'customer_id'                     => $customer->id,
                'status'                          => $inbound_invoice->status,
                'number'                          => "1234",
                'month'                           => $inbound_invoice->month,
                'deadline_id'                     => $inbound_invoice->deadline->id,
                'amount_before_taxes'             => $inbound_invoice->amount_before_taxes,
                'amount_of_taxes'                 => $inbound_invoice->amount_of_taxes,
                'amount_all_taxes_included'       => $inbound_invoice->amount_all_taxes_included,
                'note'                            => $inbound_invoice->note,
            ],
        ];

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue(
            $validator->passes()
        );
    }
}
