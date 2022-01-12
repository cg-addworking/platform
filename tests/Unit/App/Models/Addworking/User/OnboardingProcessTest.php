<?php

namespace Tests\Unit\App\Models\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\UndefinedStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OnboardingProcessTest extends TestCase
{
    use RefreshDatabase;

    public function testScopeIncomplete()
    {
        $onboarding_processes = factory(OnboardingProcess::class, 5)->state('incomplete')->create();

        $this->assertEquals(
            5,
            OnboardingProcess::incomplete()->count(),
            "There should be only 5 onboarding processes with 'incomplete' status"
        );
    }

    public function testScopeComplete()
    {
        $onboarding_processes = factory(OnboardingProcess::class, 5)->state('complete')->create();

        $this->assertEquals(
            5,
            OnboardingProcess::complete()->count(),
            "There should be only 5 onboarding processes with 'complete' status"
        );
    }

    public function testScopeStatus()
    {
        $onboarding_processes_complete = factory(OnboardingProcess::class, 5)->state('complete')->create();
        $onboarding_processes_incomplete = factory(OnboardingProcess::class, 5)->state('incomplete')->create();

        $this->assertEquals(
            5,
            OnboardingProcess::status(true)->count(),
            "There should be only 5 onboarding processes with 'complete' status"
        );

        $this->assertEquals(
            5,
            OnboardingProcess::status(false)->count(),
            "There should be only 5 onboarding processes with 'incomplete' status"
        );
    }

    public function testScopeOfEnterprise()
    {
        $onboarding_process = factory(OnboardingProcess::class)->create();

        $this->assertEquals(
            1,
            OnboardingProcess::ofEnterprise($onboarding_process->enterprise)->count(),
            "There should be only 1 onboarding process attached to enterprise : {$onboarding_process->enterprise->id}"
        );
    }

    public function testScopeOfUser()
    {
        $onboarding_process = factory(OnboardingProcess::class)->create();

        $this->assertEquals(
            1,
            OnboardingProcess::ofUser($onboarding_process->user)->count(),
            "There should be only 1 onboarding process attached to user : {$onboarding_process->user->id}"
        );
    }

    public function testScopeCurrentStep()
    {
        $onboarding_processes = factory(OnboardingProcess::class, 5)->create(['current_step' => 5]);

        $this->assertEquals(
            5,
            OnboardingProcess::currentStep(5)->count(),
            "There should be only 5 onboarding process in step 5"
        );
    }

    public function testGetCurrentStep()
    {
        $empty_process = new OnboardingProcess;

        $this->assertInstanceOf(
            UndefinedStep::class,
            $empty_process->getCurrentStep(),
            "The current step of an empty process should be an undefined step"
        );

        // @todo complete this test!
    }

    public function testStep()
    {
        $process = factory(OnboardingProcess::class)->create();

        $this->assertInstanceOf(
            UndefinedStep::class,
            $process->step(-1),
            "An invalid step number returns an invalid step instance"
        );
    }

    public function testScopeFilterUser()
    {
        $process = tap(factory(OnboardingProcess::class)->create(), function ($process) {
            $process->user->firstname = 'John';
            $process->user->lastname = 'Smith';
            $process->user->save();
        });

        $this->assertEquals(
            1,
            OnboardingProcess::filterUser('joh')->count(),
            'We should find the onboarding process by user firstname'
        );

        $this->assertEquals(
            1,
            OnboardingProcess::filterUser('mit')->count(),
            'We should find the onboarding process by user lastname'
        );

        $this->assertEquals(
            0,
            OnboardingProcess::filterUser('foo')->count(),
            'We should find 0 onboarding process by this search term'
        );
    }

    public function testScopeFilterEnterprise()
    {
        $process = tap(factory(OnboardingProcess::class)->create(), function ($process) {
            $process->enterprise->name = 'ACME Corp';
            $process->enterprise->save();
            $process->enterprise->users()->first()->delete();
            $process->enterprise->users()->attach($process->user, [
                'job_title'               => "CEO",
                'is_signatory'            => true,
                'is_legal_representative' => true,
                'current'                 => true,
                'primary'                 => true,
            ]);
        });

        $this->assertEquals(
            1,
            OnboardingProcess::filterEnterprise('acm')->count(),
            'We should find the onboarding process by user enterprise name'
        );

        $this->assertEquals(
            0,
            OnboardingProcess::filterEnterprise('foo')->count(),
            'We should find 0 onboarding process by this search term'
        );
    }

    public function testScopeFilterCustomer()
    {
        $process = tap(factory(OnboardingProcess::class)->create(), function ($process) {
            $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'ACME Corp']);
            $process->enterprise->customers()->attach($customer);
            $process->enterprise->users()->first()->delete();
            $process->enterprise->users()->attach($process->user, [
                'job_title'               => "CEO",
                'is_signatory'            => true,
                'is_legal_representative' => true,
                'current'                 => true,
                'primary'                 => true,
            ]);
        });

        $this->assertEquals(
            1,
            OnboardingProcess::filterCustomer('acm')->count(),
            'We should find the onboarding process by user enterprise customer name'
        );

        $this->assertEquals(
            0,
            OnboardingProcess::filterCustomer('foo')->count(),
            'We should find 0 onboarding process by this search term'
        );
    }

    public function testScopeSearch()
    {
        $process = tap(factory(OnboardingProcess::class)->create(), function ($process) {
            $process->user->firstname = 'John';
            $process->user->lastname = 'Smith';
            $process->user->save();

            $process->enterprise->name = 'ACME Corp';
            $process->enterprise->save();

            $customer = factory(Enterprise::class)->states('customer')->create(['name' => 'Foo Bar']);
            $process->enterprise->customers()->attach($customer);

            $process->enterprise->users()->first()->delete();
            $process->enterprise->users()->attach($process->user, [
                'job_title'               => "CEO",
                'is_signatory'            => true,
                'is_legal_representative' => true,
                'current'                 => true,
                'primary'                 => true,
            ]);
        });

        $this->assertEquals(
            1,
            OnboardingProcess::search('joh')->count(),
            'We should find the onboarding process by user firstname'
        );

        $this->assertEquals(
            1,
            OnboardingProcess::search('smi')->count(),
            'We should find the onboarding process by user lastname'
        );

        $this->assertEquals(
            1,
            OnboardingProcess::search('cor')->count(),
            'We should find the onboarding process by user enterprise name'
        );

        $this->assertEquals(
            1,
            OnboardingProcess::search('foo')->count(),
            'We should find the onboarding process by user enterprise customer name'
        );

        $this->assertEquals(
            0,
            OnboardingProcess::search('baz')->count(),
            'We should find 0 onboarding process by this search term'
        );
    }
}
