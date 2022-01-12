<?php

namespace Tests\Unit\App\Repositories\Addworking\Billing;

use App\Contracts\Billing\Invoice;
use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Billing\InboundInvoice\StoreInboundInvoiceRequest;
use App\Http\Requests\Addworking\Billing\InboundInvoice\UpdateInboundInvoiceRequest;
use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Billing\InboundInvoiceRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class InboundInvoiceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testConstruct()
    {
        $repo = $this->app->make(InboundInvoiceRepository::class);

        $this->assertInstanceof(
            Repository::class,
            $repo,
        );
    }

    /**
     * @dataProvider listDataProvider
     */
    public function testList($items, $filter, $count)
    {
        $repo = $this->app->make(InboundInvoiceRepository::class);

        $this->generateListDataItems($items);

        $this->assertEquals(
            $n = count($items),
            InboundInvoice::count(),
            "There should be exactly {$n} items in database"
        );

        $this->assertEquals(
            $count,
            $repo->list(null, $filter)->count(),
            "There should be exactly {$count} inbounds that match filter creteria"
        );
    }

    public function testCreateFromRequest()
    {
        $repo = $this->app->make(InboundInvoiceRepository::class);

        $vendor   = factory(Enterprise::class)->states('vendor')->create();
        $customer = tap(factory(Enterprise::class)->states('customer')->create(), function ($customer) use ($vendor) {
            $customer->vendors()->attach($vendor);
        });

        $inputs = [
            'inbound_invoice' => [
                'customer_id'               => $customer->id,
                'deadline_id'               => factory(DeadlineType::class)->create()->id,
                'status'                    => InboundInvoice::STATUS_TO_VALIDATE,
                'number'                    => "bar-123",
                'month'                     => Carbon::now()->format('m/Y'),
                'invoiced_at'               => Carbon::now(),
                'amount_before_taxes'       => 1234.56,
                'amount_of_taxes'           => 789.01,
                'amount_all_taxes_included' => 2345.67,
                'note'                      => "foo-test",
            ],
        ];

        $request = $this->fakeRequest(StoreInboundInvoiceRequest::class)
            ->setInputs($inputs)
            ->setFiles(['file' => ['content' => $this->fakeFile('invoice.pdf', 150, 'application/pdf')]])
            ->setUser($vendor->users()->first())
            ->obtain();

        $inbound = $repo->createFromRequest($request, $vendor);

        $this->assertDatabaseHas(
            (new InboundInvoice)->getTable(),
            ['number' => "bar-123"]
        );

        $this->assertTrue(
            $inbound->exists,
            "The invoice should exist"
        );

        $this->assertTrue(
            $inbound->file->exists,
            "The invoice file should be recorded in database",
        );

        $this->assertTrue(
            $inbound->enterprise->is($vendor),
            "The inbound should be associated to its vendor"
        );

        $this->assertTrue(
            $inbound->customer->is($customer),
            "The outbound should be associated to its customer"
        );
    }

    public function testUpdateFromRequest()
    {
        $repo = $this->app->make(InboundInvoiceRepository::class);

        $inbound  = factory(InboundInvoice::class)->create();
        $vendor   = $inbound->enterprise;
        $customer = $inbound->customer;

        $inputs = [
            'inbound_invoice' => [
                'customer_id'               => $customer->id,
                'deadline_id'               => $inbound->deadline->id,
                'status'                    => InboundInvoice::STATUS_TO_VALIDATE,
                'number'                    => "foo-123",
                'month'                     => Carbon::now()->format('m/Y'),
                'invoiced_at'               => Carbon::now(),
                'amount_before_taxes'       => 1234.56,
                'amount_of_taxes'           => 789.01,
                'amount_all_taxes_included' => 2345.67,
                'note'                      => "bar-test",
            ],
        ];

        $request = $this->fakeRequest(UpdateInboundInvoiceRequest::class)
            ->setInputs($inputs)
            ->setFiles(['file' => ['content' => $this->fakeFile('invoice_edit.pdf', 150, 'application/pdf')]])
            ->setUser($vendor->users()->first())
            ->obtain();

        $inbound = $repo->updateFromRequest($request, $vendor, $inbound);

        $this->assertDatabaseHas(
            (new InboundInvoice)->getTable(),
            ['number' => "foo-123"]
        );

        $this->assertEquals(
            "2345.67",
            $inbound->amount_all_taxes_included,
            "The invoice amount all taxes included should be 2345.67"
        );
    }

    public function listDataProvider()
    {
        return [
            'filter-using-created-at' => [
                'items' => [
                    ['properties' => ['created_at' => "2020-01-01"]],
                    ['properties' => ['created_at' => "2020-01-02"]],
                    ['properties' => ['created_at' => "2020-01-03"]],
                    ['properties' => ['created_at' => "2020-01-04"]],
                    ['properties' => ['created_at' => "2020-01-05"]],
                ],
                'filter' => [
                    'created_at' => "2020-01-03",
                ],
                'count' => 1,
            ],

            'filter-using-enterprise' => [
                'items' => [
                    ['relations' => ['enterprise' => [Enterprise::class, ['name' => "FOO"]]]],
                    ['relations' => ['enterprise' => [Enterprise::class, ['name' => "BAR"]]]],
                    ['relations' => ['enterprise' => [Enterprise::class, ['name' => "BAZ"]]]],
                    ['relations' => ['enterprise' => [Enterprise::class, ['name' => "POK"]]]],
                    ['relations' => ['enterprise' => [Enterprise::class, ['name' => "ZOO"]]]],
                ],
                'filter' => [
                    'enterprise' => "bar",
                ],
                'count' => 1,
            ],

            'filter-using-customer' => [
                'items' => [
                    ['relations' => ['customer' => [Enterprise::class, ['name' => "FOO", 'is_customer' => true]]]],
                    ['relations' => ['customer' => [Enterprise::class, ['name' => "BAR", 'is_customer' => true]]]],
                    ['relations' => ['customer' => [Enterprise::class, ['name' => "BAZ", 'is_customer' => true]]]],
                    ['relations' => ['customer' => [Enterprise::class, ['name' => "POK", 'is_customer' => true]]]],
                    ['relations' => ['customer' => [Enterprise::class, ['name' => "ZOO", 'is_customer' => true]]]],
                ],
                'filter' => [
                    'customer' => "pok",
                ],
                'count' => 1,
            ],

            'filter-using-number' => [
                'items' => [
                    ['properties' => ['number' => "1"]],
                    ['properties' => ['number' => "2"]],
                    ['properties' => ['number' => "3"]],
                    ['properties' => ['number' => "4"]],
                    ['properties' => ['number' => "5"]],
                ],
                'filter' => [
                    'number' => "3",
                ],
                'count' => 1,
            ],

            'filter-using-status' => [
                'items' => [
                    ['properties' => ['status' => Invoice::STATUS_TO_VALIDATE]],
                    ['properties' => ['status' => Invoice::STATUS_PENDING]],
                    ['properties' => ['status' => Invoice::STATUS_VALIDATED]],
                    ['properties' => ['status' => Invoice::STATUS_PAID]],
                ],
                'filter' => [
                    'status' => Invoice::STATUS_PENDING,
                ],
                'count' => 1,
            ],
            'filter-using-combination' => [
                'items' => [
                    [
                        'properties' => [
                            'created_at' => "2020-01-01",
                            'number'     => "1",
                            'status'     => Invoice::STATUS_TO_VALIDATE,
                        ],
                        'relations' => [
                            'enterprise' => [Enterprise::class, ['name' => "VENDOR 2",   'is_vendor'   => true]],
                            'customer'   => [Enterprise::class, ['name' => "CUSTOMER 1", 'is_customer' => true]]
                        ],
                    ],
                    [
                        'properties' => [
                            'created_at' => "2020-01-01",
                            'number'     => "1",
                            'status'     => Invoice::STATUS_TO_VALIDATE,
                        ],
                        'relations' => [
                            'enterprise' => [Enterprise::class, ['name' => "VENDOR 1",   'is_vendor'   => true]],
                            'customer'   => [Enterprise::class, ['name' => "CUSTOMER 1", 'is_customer' => true]]
                        ],
                    ],
                    [
                        'properties' => [
                            'created_at' => "2020-01-01",
                            'number'     => "2",
                            'status'     => Invoice::STATUS_TO_VALIDATE,
                        ],
                        'relations' => [
                            'enterprise' => [Enterprise::class, ['name' => "VENDOR 1",   'is_vendor'   => true]],
                            'customer'   => [Enterprise::class, ['name' => "CUSTOMER 1", 'is_customer' => true]]
                        ],
                    ],
                    [
                        'properties' => [
                            'created_at' => "2020-01-01",
                            'number'     => "3",
                            'status'     => Invoice::STATUS_TO_VALIDATE,
                        ],
                        'relations' => [
                            'enterprise' => [Enterprise::class, ['name' => "VENDOR 1",   'is_vendor'   => true]],
                            'customer'   => [Enterprise::class, ['name' => "CUSTOMER 1", 'is_customer' => true]]
                        ],
                    ],
                    [
                        'properties' => [
                            'created_at' => "2020-01-01",
                            'number'     => "3",
                            'status'     => Invoice::STATUS_TO_VALIDATE,
                        ],
                        'relations' => [
                            'enterprise' => [Enterprise::class, ['name' => "VENDOR 1",   'is_vendor'   => true]],
                            'customer'   => [Enterprise::class, ['name' => "CUSTOMER 2", 'is_customer' => true]]
                        ],
                    ]
                ],
                'filter' => [
                    'created_at' => "2020-01-01",
                    'status'     => Invoice::STATUS_TO_VALIDATE,
                    'enterprise' => "VENDOR 1",
                    'customer'   => "CUSTOMER 1",
                ],
                'count' => 3,
            ],
        ];
    }

    protected function generateListDataItems(array $items)
    {
        foreach ($items as $item) {
            $properties = Arr::get($item, 'properties', []);
            $relations  = Arr::get($item, 'relations', []);

            tap(factory(InboundInvoice::class)->create($properties), function ($inbound) use ($relations) {
                foreach ($relations as $relation => list($class, $data)) {
                    $inbound->$relation()->associate(
                        $class::where($data)->first() ?? factory($class)->create($data)
                    )->save();
                }
            });
        }
    }

    public function testUpdateComplianceStatusFromRequest()
    {
        $repo = $this->app->make(InboundInvoiceRepository::class);

        $inbound  = factory(InboundInvoice::class)->create();
        $customer = $inbound->customer;

        $inputs = [
            'inbound_invoice' => [
                'compliance_status' => InboundInvoice::COMPLIANCE_STATUS_VALID
            ],
        ];

        $request = $this->fakeRequest(Request::class)
            ->setInputs($inputs)
            ->setUser($customer->users()->first())
            ->obtain();

        $inbound = $repo->updateComplianceStatusFromRequest($request, $inbound);

        $this->assertDatabaseHas(
            (new InboundInvoice)->getTable(),
            ['compliance_status' => InboundInvoice::COMPLIANCE_STATUS_VALID]
        );
    }
}
