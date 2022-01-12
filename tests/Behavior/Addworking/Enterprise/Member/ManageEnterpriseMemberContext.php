<?php

namespace Tests\Behavior\Addworking\Enterprise\Member;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class ManageEnterpriseMemberContext extends TestCase implements Context
{
    use RefreshDatabase, HasGivenAndThenStep;

    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @Given /^I select "([^"]*)" enterprise containing "([^"]*)" more member with "([^"]*)" role$/
     */
    public function iSelectEnterpriseContainingMoreMemberWithRole($owner, $number, $role)
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = 'my' === trim($owner)
            ? $user->enterprises()->first()
            : factory(Enterprise::class)->create();

        for ($i = 0; $i < (int)$number; $i++) {
            $enterprise->users()->attach(factory(User::class)->create(), [
                'is_admin' => in_array($role, ['admin', 'all']),
                'is_operator' => in_array($role, ['operator', 'all']),
                'is_readonly' => in_array($role, ['readonly', 'all']),
                'is_signatory' => in_array($role, ['signatory', 'all']),
                'is_legal_representative' => in_array($role, ['legal_representative', 'all']),
            ]);
        }

        $this->context['enterprise'] = $enterprise;
    }

    /**
     * @When /^I try to access to associate's page for "([^"]*)" enterprise$/
     */
    public function iTryToAccessToAssociatePageForEnterprise($owner)
    {
        /** @var User $user */
        $user = $this->context['user'];

        $enterprise = 'my' === trim($owner)
            ? $user->permissions()->first()
            : factory(Enterprise::class)->create();

        $this->context['response'] = $this->actingAs($user)->get("/enterprise/{$enterprise->id}/member/create");
    }

    /**
     * @When /^I try to associate an user with email "([^"]*)" to this enterprise$/
     */
    public function iTryToAssociateAnUserWithEmailToThisEnterprise($email)
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];
        /** @var User $member */
        $member = $enterprise->users()->where('email', $email)->first()
            ?? factory(User::class)->create(['email' => $email]);

        $this->context['response'] = $this->actingAs($user)->post("/enterprise/{$enterprise->id}/member/store", [
           'member' => [
               'id' => $member->id,
               'job_title' => 'Stagiaire',
               'roles' => [
                   'is_operator'
               ]
           ]
        ]);
    }

    /**
     * @When /^I try to list all member from "([^"]*)" enterprise$/
     */
    public function iTryToListAllMemberFromEnterprise($owner)
    {
        /** @var User $user */
        $user = $this->context['user'];

        $enterprise = 'my' === trim($owner)
            ? $user->permissions()->first()
            : factory(Enterprise::class)->create();

        $this->context['response'] = $this->actingAs($user)->get("/enterprise/{$enterprise->id}/member");
    }

    /**
     * @When /^I try to edit any member from "([^"]*)" enterprise$/
     */
    public function iTryToEditAnyMemberFromEnterprise($owner)
    {
        /** @var User $user */
        $user = $this->context['user'];

        $enterprise = 'my' === trim($owner)
            ? $user->permissions()->first()
            : factory(Enterprise::class)->create();

        $this->context['response'] = $this->actingAs($user)->get(
            "enterprise/{$enterprise->id}/member/{$user->id}/edit"
        );
    }

    /**
     * @When /^I try to remove "([^"]*)" role from an "([^"]*)" member$/
     */
    public function iTryToRemoveRoleForFromThisEnterprise($member_role, $role)
    {
        list($user, $enterprise, $member) = $this->getMemberByRole($role);

        $roles = $member->getRolesFor($enterprise);
        if (($key = array_search("is_{$member_role}", $roles)) !== false) {
            unset($roles[$key]);
        }

        $this->context['response'] = $this->actingAs($user)->post(
            "/enterprise/{$enterprise->id}/member/{$member->id}/update",
            [
                'member' => [
                    'job_title' => 'Stagiaire',
                    'roles' => $roles
                ]
            ]
        );
    }

    /**
     * @When /^I try to dissociate an "([^"]*)" member from this enterprise$/
     */
    public function iTryToDissociateAnFromThisEnterprise($role)
    {
        /** @var User $user */
        list($user, $enterprise, $member) = $this->getMemberByRole($role);

        $this->context['response'] = $this->actingAs($user)->delete(
            "/enterprise/{$enterprise->id}/member/{$member->id}/remove"
        );
    }

    protected function getMemberByRole($role): array
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];

        $member = $enterprise->users()->wherePivot("is_{$role}", true)->first();
        return array($user, $enterprise, $member);
    }

    /**
     * @Given /^I have a customer enterprise$/
     */
    public function iHaveACustomerEnterprise()
    {
        $enterprise = $this->context['enterprise'];

        $customer = tap(
            factory(Enterprise::class)->state('customer')->create(),
            function ($customer) use ($enterprise) {
                $customer->vendors()->attach($enterprise);
            }
        );

        $this->context['customer'] = $customer;
    }

    /**
     * @When /^I try to list all members of customer enterprise$/
     */
    public function iTryToListAllMembersOfCustomerEnterprise()
    {
        $user = $this->context['user'];
        $customer = $this->context['customer'];
        $this->context['response'] = $this->actingAs($user)->get("/enterprise/{$customer->id}/member");
    }
}
