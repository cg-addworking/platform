<?php

namespace Tests\Behavior;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Testing\TestResponse;

trait HasGivenAndThenStep
{
    protected $context = [];

    /**
     * @Given /^Im authenticated as "([^"]*)" from "([^"]*)" enterprise$/
     */
    public function imAuthenticatedAsUser($role, $type)
    {
        if ($role !== 'support') {
            $user = factory(User::class)->create();
            $enterprise = $type !== 'any'
                ? factory(Enterprise::class)->states($type)->make()
                : factory(Enterprise::class)->make();
            $enterprise->save();
            $enterprise->users()->attach($user, [
                'is_admin' => 'admin' === $role,
                'is_operator' => 'operator' === $role,
                'is_readonly' => 'readonly' === $role,
                'is_signatory' => 'signatory' === $role,
                'is_legal_representative' => 'legal_representative' === $role,
            ]);

            $this->context['enterprise'] = $enterprise;
        } else {
            $user = factory(User::class)->states('support')->create();
            $this->context['enterprise'] = factory(Enterprise::class)->create();
        }

        $this->context['user'] = $user;
    }

    /**
     * @Given /^This enterprise contains a member with "([^"]*)" as email$/
     */
    public function thisEnterpriseContainsAMemberWithAsEmail($email)
    {
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];

        $enterprise->users()->attach(factory(User::class)->create(['email' => $email]), [
            'is_operator' => true,
            'job_title' => 'Stagiaire'
        ]);
    }

    /**
     * @Then /^I "([^"]*)" be able to pursue this action$/
     * @Then /^He "([^"]*)" be able to pursue this action$/
     * @Then /^It "([^"]*)" be able to pursue this action$/
     */
    public function iBeAbleToPursueThisAction($ability)
    {
        /** @var TestResponse $response */
        $response = $this->context['response'];

        if ($ability === 'should') {
            $this->assertTrue($response->isRedirect() || $response->isOk());
        } else {
            if ($response->isForbidden()) {
                $response->assertForbidden();
            } else {
                $response->assertSessionHasErrors();
            }
        }
    }
}
