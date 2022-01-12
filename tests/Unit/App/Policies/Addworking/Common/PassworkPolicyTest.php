<?php


namespace Tests\Unit\App\Policies\Addworking\Common;

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Policies\Addworking\Common\PassworkPolicy;
use Tests\TestCase;

class PassworkPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $policy = $this->app->make(PassworkPolicy::class);

        $user_vendor   = factory(User::class)->create();
        $user_customer   = factory(User::class)->create();
        $enterprise_vendor = factory(Enterprise::class)->create(['is_vendor' => true]);
        $enterprise_vendor->users()->attach($user_vendor, [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => true,
            'primary'                 => true,
        ]);

        $enterprise_customer = factory(Enterprise::class)->create(['is_customer' => true]);
        $enterprise_customer->users()->attach($user_customer, [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => true,
            'primary'                 => true,
        ]);

        $enterprise_sogetrel = factory(Enterprise::class)->create(['is_customer' => true]);
        $enterprise_sogetrel->name = 'SOGETREL';
        $enterprise_sogetrel->save();

        $this->assertFalse(
            $policy->index($user_customer, $user_customer->enterprise)->allowed()
        );

        $this->assertFalse(
            $policy->index($user_vendor, $user_vendor->enterprise)->allowed()
        );

        $enterprise_customer->vendors()->syncWithoutDetaching($enterprise_vendor->id);
        $job = (new Job)->make(['name' => "OPL"] + ['display_name' => "OPL", 'description' => null]);
        $job->enterprise()->associate($enterprise_customer)->save();
        $skill = (new Skill)->make(['name' => "Piloter"] + ['display_name' => "Piloter", 'description' => null]);
        $skill->job()->associate($job)->save();

        $this->assertFalse(
            $policy->index($user_customer, $user_customer->enterprise)->allowed()
        );

        $this->assertTrue(
            $policy->index($user_vendor, $user_vendor->enterprise)->allowed()
        );
    }
}
