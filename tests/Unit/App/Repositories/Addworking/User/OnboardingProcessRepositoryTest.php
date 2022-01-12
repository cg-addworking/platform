<?php

namespace Tests\Unit\App\Repositories\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\User\OnboardingProcessRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class OnboardingProcessRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFind()
    {
        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_process = factory(OnboardingProcess::class)->create();

        $this->assertTrue($repository->find($onboarding_process)->is($onboarding_process));
    }

    public function testList()
    {
        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_processes = factory(OnboardingProcess::class, 3)->create();

        $this->assertEquals($repository->list()->count(), 3);
    }

    public function testCreate()
    {
        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_process_data = factory(OnboardingProcess::class)
            ->make()
            ->only('current_step', 'complete', 'started_at', 'completed_at');

        $onboarding_process_data['enterprise'] = factory(Enterprise::class)->create()->id;
        $onboarding_process_data['user']       = factory(User::class)->create()->id;

        $onboarding_process = $repository->create($onboarding_process_data);

        $this->assertDatabaseHas(
            $this->app->make(OnboardingProcess::class)->getTable(),
            ['id' => $onboarding_process->id, 'complete' => false]
        );
    }

    public function testUpdate()
    {
        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_process = factory(OnboardingProcess::class)->create();

        $this->assertTrue($repository->update($onboarding_process, ['complete' => true]));

        $this->assertDatabaseHas(
            $this->app->make(OnboardingProcess::class)->getTable(),
            ['id' => $onboarding_process->id, 'complete' => true]
        );
    }

    public function testDelete()
    {
        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_process = factory(OnboardingProcess::class)->create();

        $this->assertTrue($repository->delete($onboarding_process));

        $this->assertDatabaseMissing(
            $this->app->make(OnboardingProcess::class)->getTable(),
            ['id' => $onboarding_process->id]
        );
    }

    public function testCreateFromRequest()
    {
        $onboarding_process_data = factory(OnboardingProcess::class)
            ->make()
            ->only('current_step', 'complete', 'started_at', 'completed_at');
        $onboarding_process_data['enterprise'] = factory(Enterprise::class)->create()->id;
        $onboarding_process_data['user']       = factory(User::class)->create()->id;

        $requestParams = ['onboarding_process' => $onboarding_process_data];

        $request = Request::create('/addworking/onboarding_process/', 'POST', $requestParams);

        $repository = $this->app->make(OnboardingProcessRepository::class);
        $onboarding_process = $repository->createFromRequest($request);

        $this->assertDatabaseHas(
            $this->app->make(OnboardingProcess::class)->getTable(),
            ['id' => $onboarding_process->id]
        );
    }
}
