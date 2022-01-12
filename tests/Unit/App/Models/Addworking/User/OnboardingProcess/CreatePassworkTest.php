<?php


namespace Tests\Unit\App\Models\Addworking\User\OnboardingProcess;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\OnboardingProcess\CreatePasswork;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Common\Passwork;
use Tests\TestCase;

class CreatePassworkTest extends TestCase
{
    use RefreshDatabase;

    public function testPassesSuccess()
    {
        $step = new CreatePasswork(factory(OnboardingProcess::class)->create());
        $enterprise_vendor = factory(Enterprise::class)->create(['is_vendor' => true]);
        $enterprise_vendor->users()->attach($step->user(), [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => true,
            'primary'                 => true,
        ]);

        // if the vendor is not attached to any customer
        $this->assertEquals($step->passes(), true);

        $enterprise_customer = factory(Enterprise::class)->create(['is_customer' => true]);
        $enterprise_customer->vendors()->syncWithoutDetaching($enterprise_vendor->id);

        // if the vendor is attached to a customer but the customer has not defined a job / skills
        $this->assertEquals($step->passes(), true);
        $job = (new Job)->make(['name' => "OPL"] + ['display_name' => "OPL", 'description' => null]);
        $job->enterprise()->associate($enterprise_customer)->save();
        $skill = (new Skill)->make(['name' => "Piloter"] + ['display_name' => "Piloter", 'description' => null]);
        $skill->job()->associate($job)->save();

        $passwork = $this->app->make(Passwork::class);
        $passwork->customer()->associate($enterprise_customer);
        $passwork->passworkable()->associate($step->user()->enterprise);
        $passwork->save();
        $passwork->skills()->attach($skill->id, ['level' => "1"]);

        // if the vendor has a passwork created and entered a skill
        $this->assertEquals($step->passes(), true);
    }

    public function testPassesFail()
    {
        $step = new CreatePasswork(factory(OnboardingProcess::class)->create());
        $enterprise_vendor = factory(Enterprise::class)->create(['is_vendor' => true]);
        $enterprise_vendor->users()->attach($step->user(), [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => true,
            'primary'                 => true,
        ]);

        $enterprise_customer = factory(Enterprise::class)->create(['is_customer' => true]);
        $enterprise_customer->vendors()->syncWithoutDetaching($enterprise_vendor->id);

        $job = (new Job)->make(['name' => "OPL"] + ['display_name' => "OPL", 'description' => null]);
        $job->enterprise()->associate($enterprise_customer)->save();
        $skill = (new Skill)->make(['name' => "Piloter"] + ['display_name' => "Piloter", 'description' => null]);
        $skill->job()->associate($job)->save();

        // if the vendor is attached to a customer and the customer has defined a job / skills
        // but the vendor did not fill in his passwork
        $this->assertEquals($step->passes(), false);

        $passwork = $this->app->make(Passwork::class);
        $passwork->customer()->associate($enterprise_customer);
        $passwork->passworkable()->associate($step->user()->enterprise);
        $passwork->save();

        // if the vendor has a passwork created but has not entered a skill
        $this->assertEquals($step->passes(), false);
    }
}
