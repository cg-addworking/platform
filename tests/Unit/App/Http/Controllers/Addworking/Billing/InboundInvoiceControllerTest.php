<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Billing;

use App\Http\Controllers\Addworking\Billing\InboundInvoiceController;
use App\Http\Controllers\Controller;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use Illuminate\View\View;
use Tests\TestCase;

class InboundInvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $this->assertInstanceof(
            Controller::class,
            $this->app->make(InboundInvoiceController::class),
            "The controller should be a controller"
        );
    }

    public function testUpdateComplianceStatus()
    {
        $controller = $this->app->make(InboundInvoiceController::class);
        $inbound    = factory(InboundInvoice::class)->create();
        $support    = factory(User::class)->states('support')->create();

        $response = TestResponse::fromBaseResponse(
            $controller->updateComplianceStatus(
                $this->fakeRequest(Request::class)
                    ->setInputs([
                        'inbound_invoice' => [
                            'compliance_status' => InboundInvoice::COMPLIANCE_STATUS_VALID
                        ]
                    ])
                    ->setUser($support)
                    ->obtain(),
                $inbound->enterprise,
                $inbound
            )
        );

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            (new InboundInvoice())->getTable(),
            [
                'compliance_status'       => InboundInvoice::COMPLIANCE_STATUS_VALID,
            ]
        );
    }
}
