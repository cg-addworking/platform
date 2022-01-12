<?php

namespace Tests\Behavior\Addworking\Enterprise\Invitation;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Enterprise\InviteMemberNotification;
use App\Notifications\Addworking\Enterprise\InviteVendorNotification;
use App\Support\Token\InvitationTokenManager;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class ManageEnterpriseInvitationContext extends TestCase implements Context
{
    use HasGivenAndThenStep, RefreshDatabase;

    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @Given /^I created a "([^"]*)" invitation with "([^"]*)" status$/
     */
    public function iCreatedAInvitation($type, $status)
    {
        $enterprise = $this->context['enterprise'];

        /** @var Invitation $invitation */
        $invitation = factory(Invitation::class)->make([
            'type' => $type === 'member' ? Invitation::TYPE_MEMBER : Invitation::TYPE_VENDOR,
            'status' => $status === 'any' ? Invitation::STATUS_PENDING : $status
        ]);
        $invitation->host()->associate($enterprise);
        $invitation->save();

        $this->context['invitation'] = $invitation;
    }

    /**
     * @Given /^An invitation sent to "([^"]*)"$/
     */
    public function anInvitationSentToFromAnEnterprise($email)
    {
        $enterprise = factory(Enterprise::class)->create();
        /** @var Invitation $invitation */
        $invitation = factory(Invitation::class)->make([
            'contact' => $email,
            'type' => array_random([Invitation::TYPE_MEMBER, Invitation::TYPE_VENDOR]),
            'status' => Invitation::STATUS_PENDING,
        ]);
        $invitation->host()->associate($enterprise);
        $invitation->save();

        $this->context['enterprise'] = $enterprise;
        $this->context['invitation'] = $invitation;
    }

    /**
     * @When /^I try to create an "([^"]*)" invitation$/
     */
    public function iTryToCreateAnInvitation($type)
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];
        $type = 'any' === $type ? 'member' : $type;

        $this->context['response'] = $this->actingAs($user)
            ->get("addworking/enterprise/{$enterprise->id}/{$type}/invitation/create");
    }

    /**
     * @When /^I try to create a "([^"]*)" invitation for "([^"]*)" email$/
     */
    public function iTryToCreateAInvitationForEmail($type, $email)
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];
        $type = 'any' === $type ? 'member' : $type;
        $data = $type === 'member'
            ? ['email' => $email, 'member' => ['roles' => ['is_operator']]]
            : ['emails' => [$email]];

        $this->context['response'] = $this->actingAs($user)
            ->post("addworking/enterprise/{$enterprise->id}/{$type}/invitation/store", $data);
    }

    /**
     * @When /^I try to list all invitations from "([^"]*)" enterprise$/
     */
    public function iTryToListAllInvitationsFromEnterprise($own)
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $own === 'my'
            ? $this->context['enterprise']
            : factory(Enterprise::class)->create();

        $this->context['response'] = $this->actingAs($user)->get("addworking/enterprise/{$enterprise->id}/invitation");
    }

    /**
     * @When /^I try to delete this invitation$/
     */
    public function iTryToDeleteThisInvitation()
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];
        /** @var Invitation $invitation */
        $invitation = $this->context['invitation'];

        $this->context['response'] = $this->actingAs($user)
            ->delete("addworking/enterprise/{$enterprise->id}/invitation/{$invitation->id}/destroy");
    }

    /**
     * @When /^I try to relaunch this invitation$/
     */
    public function iTryToRelaunchThisInvitation()
    {
        /** @var User $user */
        $user = $this->context['user'];
        /** @var Enterprise $enterprise */
        $enterprise = $this->context['enterprise'];
        /** @var Invitation $invitation */
        $invitation = $this->context['invitation'];

        $this->context['response'] = $this->actingAs($user)
            ->get("addworking/enterprise/{$enterprise->id}/invitation/{$invitation->id}/relaunch");
    }

    /**
     * @When /^The guest try to "([^"]*)" this invitation$/
     */
    public function theGuestTryToThisInvitation($action)
    {
        $invitation = $this->context['invitation'];

        switch ($action) {
            case 'refuse':
                $this->context['response'] = $this->get(
                    "/addworking/enterprise/invitation/response?token={$this->prepareToken(false)}"
                );
                break;
            case 'accept':
                $this->context['response'] = $this->get(
                    "/addworking/enterprise/invitation/response?token={$this->prepareToken(true)}"
                );
                break;
            case 'review':
                $this->context['response'] = $this->get(
                    "/addworking/enterprise/{$invitation->type}/invitation/review?token={$this->prepareToken(true)}"
                );
                break;
            default:
                throw new PendingException();
        }
    }

    /**
     * @Then /^The invitation should be in "([^"]*)" status$/
     */
    public function theInvitationShouldBeInStatus($status)
    {
        $token = $this->app->make(InvitationTokenManager::class)->decode($this->context['token']);

        $this->assertEquals($status, Invitation::find($token->invitation_id)->status);
    }

    private function prepareToken(bool $isAccepted): string
    {
        /** @var Invitation $invitation */
        $invitation = $this->context['invitation'];
        $manager = $this->app->make(InvitationTokenManager::class);

        $payload = $invitation->type === Invitation::TYPE_MEMBER
            ? (new InviteMemberNotification($invitation, $manager))->prepareTokenData(['is_accepted' => $isAccepted])
            : (new InviteVendorNotification($invitation, $manager))->prepareTokenData(['is_accepted' => $isAccepted]);

        $token = $manager->encode($payload);
        $this->context['token'] = $token;

        return $token;
    }
}
