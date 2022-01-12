<?php

namespace Tests\Unit\App\Http\Controllers\Support\Billing;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InboundInvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('/support/inbound_invoice');
        $response->assertStatus(403);
    }
}
