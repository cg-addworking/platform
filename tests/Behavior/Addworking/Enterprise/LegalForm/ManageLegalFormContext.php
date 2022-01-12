<?php

namespace Tests\Behavior\Addworking\Enterprise\LegalForm;

use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class ManageLegalFormContext extends TestCase implements Context
{
    use RefreshDatabase, HasGivenAndThenStep;

    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @When /^I try to create a legal form$/
     */
    public function iTryToCreateALegalForm()
    {
        /** @var User $user */
        $user = $this->context['user'];

        $this->context['response'] = $this->actingAs($user)->get("support/legal-form/create");
    }

    /**
     * @When /^I try to store a legal form$/
     */
    public function iTryToStoreALegalForm()
    {
        /** @var User $user */
        $user = $this->context['user'];
        $this->context['legal_form'] = [
            'display_name' => 'toto',
            'country' => 'fr',
            'name' => 'toto'
        ];

        $this->context['response'] = $this->actingAs($user)->post(
            "/support/legal-form",
            ['legal_form' => $this->context['legal_form']]
        );
    }

    /**
     * @When /^I try to list all legal form$/
     */
    public function iTryToListAllLegalForm()
    {
        /** @var User $user */
        $user = $this->context['user'];

        $this->context['response'] = $this->actingAs($user)->get("support/legal-form");
    }

    /**
     * @Then /^I "([^"]*)" see that a new form legal has been created$/
     */
    public function iShouldSeeThatANewFormLegalHasBeenCreated($ability)
    {
        if ($ability === 'should') {
            $this->assertDatabaseHas('addworking_enterprise_legal_forms', $this->context['legal_form']);
        } else {
            $this->assertDatabaseMissing('addworking_enterprise_legal_forms', $this->context['legal_form']);
        }
    }
}
