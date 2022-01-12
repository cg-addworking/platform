<?php

namespace Tests\Behavior\Addworking\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\Mission\ProposalIsInterestingForVendorNotification;
use App\Policies\Addworking\Mission\ProposalPolicy;
use App\Policies\Addworking\Mission\ProposalResponsePolicy;
use Behat\Behat\Context\Context;
use Illuminate\Support\Facades\Notification;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class RequestInformationForProposalContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $sogetrel;

    protected $customer;

    protected $customerUser;

    protected $vendor;

    protected $vendorUser;

    protected $proposal;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @When /^un vendor sogetrel$/
     */
    public function sogetrelVendor()
    {
        $this->sogetrel = factory(Enterprise::class)->states('customer')->create([
            'name' => 'SOGETREL'
        ]);
        $this->customer = factory(Enterprise::class)->states('customer')->create();
        $this->customer->parent()->associate($this->sogetrel)->save();
        $this->customerUser = factory(User::class)->create();
        $this->customer->users()->attach($this->customerUser, [
            'is_admin' => true,
        ]);

        $this->vendor = factory(Enterprise::class)->states('vendor')->create();
        $this->vendorUser = factory(User::class)->create();
        $this->vendor->users()->attach($this->vendorUser, [
            'is_admin' => true,
        ]);
        $this->customer->vendors()->syncWithoutDetaching($this->vendor->id);

        $this->assertEquals('1', $this->customer->vendors->count(), 'this should be equal to 1');
        $this->assertTrue($this->vendor->isVendorOfSogetrelSubsidiaries(), 'I am a vendor of sogetrel');
    }

    /**
     * @When /^je reçois une proposition de mission$/
     */
    public function iReceiveAProposal()
    {
        $this->proposal = factory(Proposal::class)->create([
            'status' => Proposal::STATUS_RECEIVED,
        ]);
        $offer = $this->proposal->offer;
        $offer->customer = $this->customer;
        $this->proposal->vendor()->associate($this->vendor);
        $this->proposal->createdBy()->associate($this->customerUser);
        $this->proposal->save();

        $this->assertEquals('1', Proposal::count());
    }

    /**
     * @When /^le statut de la proposition est à “reçu”$/
     */
    public function proposalStatusIsReceived()
    {
        $this->assertEquals(Proposal::STATUS_RECEIVED, $this->proposal->status);
    }

    /**
     * @When /^je peux faire une demande d'information$/
     */
    public function iCanRequestInformation()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->interestedStatus($this->vendorUser, $this->proposal),
            'I can ask for information about the proposal'
        );
    }

    /**
     * @When /^je ne peux pas répondre à l’appel d’offre$/
     */
    public function iCanNotAnswerTheOffer()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertFalse(
            $policy->create($this->vendorUser, $this->proposal),
            'As a sogetrel vendor, I can not create a proposal response when the proposal status is set to received'
        );
    }

    /**
     * @When /^un vendor non sogetrel$/
     */
    public function vendorNoSogetrel()
    {
        $this->customer = factory(Enterprise::class)->states('customer')->create();

        $this->customerUser = factory(User::class)->create();

        $this->customer->users()->attach($this->customerUser, [
            'is_admin' => true,
        ]);

        $this->vendor = factory(Enterprise::class)->states('vendor')->create();

        $this->vendorUser = factory(User::class)->create();

        $this->vendor->users()->attach($this->vendorUser, [
            'is_admin' => true,
        ]);

        $this->customer->vendors()->syncWithoutDetaching($this->vendor->id);

        $this->assertEquals('1', $this->customer->vendors->count());

        $this->assertFalse($this->vendor->isVendorOfSogetrelSubsidiaries(), 'I am not a vendor of sogetrel');
    }

    /**
     * @When /^je ne peux pas répondre à l\'([^\']*)\'offre$/
     */
    public function iCantCreateProposalResponse()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertFalse(
            $policy->create($this->vendorUser, $this->proposal),
            'I can not create a response for the proposal'
        );
    }

    /**
     * @When /^je ne peux pas faire une demande d'information$/
     */
    public function iCantRequestInformation()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertFalse(
            $policy->interestedStatus($this->vendorUser, $this->proposal),
            'I can not ask for information about the proposal'
        );
    }

    /**
     * @When /^je peux répondre à l\'([^\']*)\'offre$/
     */
    public function iCanCreateProposalResponse()
    {
        $policy = $this->app->make(ProposalResponsePolicy::class);

        $this->assertTrue(
            $policy->create($this->vendorUser, $this->proposal),
            'I can not create a response for the proposal'
        );
    }

    /**
     * @When /^j'ai une proposition de mission au statut “BPU transmis” ou “répondu”$/
     */
    public function iReceiveAProposalWithBpuSendedOrAnsweredStatus()
    {
        $this->proposal = factory(Proposal::class)->create([
            'status' => Proposal::STATUS_ANSWERED,
        ]);
        $offer = $this->proposal->offer;
        $offer->customer = $this->customer;
        $this->proposal->vendor()->associate($this->vendor);
        $this->proposal->createdBy()->associate($this->customerUser);
        $this->proposal->save();

        $this->assertEquals(Proposal::STATUS_ANSWERED, $this->proposal->status);
    }

    /**
     * @When /^j'ai accès aux commentaires$/
     */
    public function iHaveAccessToComments()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->viewCommentsTab($this->vendorUser, $this->proposal),
            'I have access to comments'
        );
    }

    /**
     * @When /^je n'ai pas accès aux commentaires$/
     */
    public function iDoNotHaveAccessToComments()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertFalse(
            $policy->viewCommentsTab($this->vendorUser, $this->proposal),
            'I do not have access to comments'
        );
    }

    /**
     * @When /^je demande une information$/
     */
    public function iRequestInformation()
    {
        $data = [
            "proposal" => [
                "status" => Proposal::STATUS_INTERESTED,
            ],
            "comment" => [
                "commentable_id"   => $this->proposal->id,
                "commentable_type" => "proposal",
                "content"          => "this is a comment",
                "visibility"       => "public",
            ]
        ];

        $response = $this
            ->actingAs($this->vendorUser)
            ->post($this->proposal->routes->status, $data);

        $response->assertRedirect($this->proposal->routes->show);
    }

    /**
     * @When /^je dois renseigner un commentaire$/
     */
    public function iMustInquireAComment()
    {
        $this->assertDatabaseHas('addworking_common_comments', [
            'commentable_id' => $this->proposal->id,
            'content'        => "this is a comment",
        ]);
    }

    /**
     * @When /^le statut de la proposition passe à “Intéressé”$/
     */
    public function proposalStatusIsSetToInterested()
    {
        $this->proposal->refresh();

        $this->assertEquals(Proposal::STATUS_INTERESTED, $this->proposal->status);
    }

    /**
     * @When /^un mail est envoyé au référent de l'offre de la proposition de mission$/
     */
    public function aMailIsSentToTheOfferReferentOfTheProposal()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        Notification::assertNothingSent();

        Notification::send(
            $this->proposal->offer->referent,
            new ProposalIsInterestingForVendorNotification($this->proposal)
        );

        $proposal = $this->proposal;
        $referent  = $proposal->offer->referent;

        Notification::assertSentTo(
            $referent,
            ProposalIsInterestingForVendorNotification::class,
            function ($notification, $channels) use ($proposal, $referent) {

                $mail_data = $notification->toMail($referent)->toArray();

                $this->assertEquals(
                    'Un prestataire est interessé à votre offre '. $proposal->offer->label,
                    $mail_data['subject']
                );

                return $notification->proposal->is($proposal);
            }
        );
    }

    /**
     * @When /^un customer non sogetrel$/
     */
    public function noSogetrelCustomer()
    {
        $this->sogetrel = factory(Enterprise::class)->states('customer')->create([
            'name' => 'SOGETREL'
        ]);
        $this->customer = factory(Enterprise::class)->states('customer')->create();

        $this->customerUser = factory(User::class)->create();

        $this->customer->users()->attach($this->customerUser, [
            'is_admin' => true,
        ]);

        $this->assertTrue($this->customer->isCustomer());

        $this->assertFalse($this->sogetrel->family()->contains($this->customer));
    }

    /**
     * @When /^je n'ai pas accès aux propositions$/
     */
    public function iDoNotHaveAccessToProposals()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertFalse(
            $policy->index($this->customerUser),
            'I do not have access to proposals'
        );
    }

    /**
     * @When /^un customer sogetrel$/
     */
    public function sogetrelCustomer()
    {
        $this->sogetrel = factory(Enterprise::class)->states('customer')->create([
            'name' => 'SOGETREL'
        ]);
        $this->customer = factory(Enterprise::class)->states('customer')->create();
        $this->customer->parent()->associate($this->sogetrel)->save();
        $this->customerUser = factory(User::class)->create();

        $this->customer->users()->attach($this->customerUser, [
            'is_admin' => true,
        ]);

        $this->assertTrue($this->customer->isCustomer());

        $this->assertTrue($this->customer->isMemberOfFamily($this->sogetrel));
    }

    /**
     * @When /^j'ai accès aux propositions$/
     */
    public function iHaveAccessToProposals()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->index($this->customerUser),
            'I do have access to proposals'
        );
    }

    /**
     * @When /^un vendor$/
     */
    public function vendor()
    {
        $this->customer = factory(Enterprise::class)->states('customer')->create();

        $this->customerUser = factory(User::class)->create();

        $this->customer->users()->attach($this->customerUser, [
            'is_admin' => true,
        ]);

        $this->vendor = factory(Enterprise::class)->states('vendor')->create();

        $this->vendorUser = factory(User::class)->create();

        $this->vendor->users()->attach($this->vendorUser, [
            'is_admin' => true,
        ]);

        $this->customer->vendors()->syncWithoutDetaching($this->vendor->id);
    }

    /**
     * @When /^je peux accéder aux propositions$/
     */
    public function ICanAccessToProposals()
    {
        $policy = $this->app->make(ProposalPolicy::class);

        $this->assertTrue(
            $policy->index($this->vendorUser),
            'I do have access to proposals as a vendor'
        );
    }
}
