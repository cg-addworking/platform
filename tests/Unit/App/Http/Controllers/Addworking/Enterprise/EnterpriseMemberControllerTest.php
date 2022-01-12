<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Addworking\Enterprise\EnterpriseMemberController;
use App\Http\Requests\Addworking\Enterprise\Member\StoreEnterpriseMemberRequest;
use App\Http\Requests\Addworking\Enterprise\Member\UpdateEnterpriseMemberRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class EnterpriseMemberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        /** @var Enterprise $enterprise */
        $enterprise = factory(Enterprise::class)->create();
        $support = factory(User::class)->states('support')->create();
        $member = factory(User::class)->create();

        $input = [
            'member' => [
                'id' => $member->id,
                'job_title' => 'Stagiaire',
                'roles' => ['is_admin']
            ]
        ];

        /** @var StoreEnterpriseMemberRequest $request */
        $request = $this->fakeRequest(StoreEnterpriseMemberRequest::class)
                        ->setInputs($input)
                        ->setUser($support)
                        ->obtain();

        $this->app->make(EnterpriseMemberController::class)->store($enterprise, $request);

        $this->assertDatabaseHas('addworking_enterprise_enterprises_has_users', [
            'enterprise_id' => $enterprise->id,
            'user_id' => $member->id,
            'job_title' => 'Stagiaire',
            'is_admin' => true
        ]);
    }

    public function testUpdate()
    {
        /** @var Enterprise $enterprise */
        $enterprise = factory(Enterprise::class)->create();
        $support = factory(User::class)->states('support')->create();
        $member = $enterprise->users()->first();

        $input = [
            'member' => [
                'job_title' => 'Stagiaire',
                'roles' => [
                    'is_readonly' => true,
                    'is_operator' => true,
                    'is_legal_representative' => true
                ]
            ]
        ];

        /** @var UpdateEnterpriseMemberRequest $request */
        $request = $this->fakeRequest(UpdateEnterpriseMemberRequest::class)
                        ->setInputs($input)
                        ->setUser($support)
                        ->obtain();

        $this->app->make(EnterpriseMemberController::class)->update($request, $enterprise, $member);

        $this->assertDatabaseHas('addworking_enterprise_enterprises_has_users', [
            'enterprise_id' => $enterprise->id,
            'user_id' => $member->id,
            'job_title' => 'Stagiaire',
            'is_readonly' => true,
            'is_operator' => true,
            'is_legal_representative' => true
        ]);
    }

    public function testDestroy()
    {
        /** @var Enterprise $enterprise */
        $enterprise = factory(Enterprise::class)->create();
        $member = factory(User::class)->create();
        $enterprise->users()->attach($member, [
            'is_operator' => true,
            'job_title' => 'Stagiaire'
        ]);

        $this->actingAs(factory(User::class)->states('support')->create())
             ->delete("/enterprise/{$enterprise->id}/member/{$member->id}/remove")
             ->assertRedirect();

        $this->assertDatabaseMissing('addworking_enterprise_enterprises_has_users', [
            'enterprise_id' => $enterprise->id,
            'user_id' => $member->id
        ]);
    }
}
