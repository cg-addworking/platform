<?php

namespace Tests\Unit\App\Repositories\Addworking\Enterprise;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class EnterpriseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFind()
    {
        $repo = app(EnterpriseRepository::class);
        $enterprise = factory(Enterprise::class)->create();

        $this->assertTrue($repo->find($enterprise)->is($enterprise));
    }

    public function testList()
    {
        $repo = app(EnterpriseRepository::class);
        $enterprises = factory(Enterprise::class, 3)->create();

        $this->assertEquals($repo->list()->count(), 4);
    }

    public function testCreate()
    {
        $repo = app(EnterpriseRepository::class);
        $enterprise = factory(Enterprise::class)->make();

        $this->assertTrue($repo->create($enterprise->toArray()) instanceof Enterprise);
    }

    public function testUpdate()
    {
        $repo = app(EnterpriseRepository::class);
        $enterprise = factory(Enterprise::class)->create();

        $this->assertTrue($repo->update($enterprise, ['name' => "foobar"]));
    }

    public function testDelete()
    {
        $repo = app(EnterpriseRepository::class);
        $enterprise = factory(Enterprise::class)->create();

        $this->assertTrue($repo->delete($enterprise));
    }

    public function testCreateFromRequest()
    {
        $requestParams = [
            'enterprise' => factory(Enterprise::class)->make()->toArray(),
            'enterprise_activity' => factory(EnterpriseActivity::class)->make()->toArray(),
            'address' => factory(Address::class)->make()->toArray(),
            'member' => [
                'job_title' => 'random job title',
            ],
            'phone_number' => [
                '1' => [
                    'number' => factory(PhoneNumber::class)->make()->number,
                    'note' => 'note 1',
                ],
                '2' => [
                    'number' => factory(PhoneNumber::class)->make()->number,
                    'note' => 'note 2',
                ],
            ],
            'member' => [
                'job_title' => 'ABC',
            ]
        ];

        $request = Request::create('/enterprise', 'POST', $requestParams);
        $request->setUserResolver(function () {
            return factory(User::class)->create();
        });

        $repo = app(EnterpriseRepository::class);
        $enterprise = $repo->createFromRequest($request);

        $this->assertTrue($enterprise->exists);
        $this->assertEquals($enterprise->activities()->count(), 1);
        $this->assertEquals($enterprise->addresses()->count(), 1);
        $this->assertEquals($enterprise->phoneNumbers()->count(), 2);
    }
}
