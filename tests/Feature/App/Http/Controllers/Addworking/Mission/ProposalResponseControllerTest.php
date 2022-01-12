<?php

namespace Tests\Feature\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ProposalResponseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testChangeResponseStatusRedirectsGuests()
    {
        $proposal_response = factory(ProposalResponse::class)->states('pending')->create();

        $response = $this->post($proposal_response->routes->status);
        $response->assertRedirect('login');
    }

    /**
     * @dataProvider proposalResponseChangeStatusFormData
     */
    public function testChangeResponseStatusSucceded($data)
    {
        $proposal_response = factory(ProposalResponse::class)->states('pending')->create();
        $proposal_response->proposal->offer->update(['status' => Offer::STATUS_COMMUNICATED]);

        Arr::set($data, 'comment.commentable_id', $proposal_response->id);

        $response = $this
            ->actingAs($proposal_response->proposal->offer->createdBy)
            ->post($proposal_response->routes->status, $data);

        $response->assertRedirect($proposal_response->routes->show);

        $proposal_response->refresh();

        $this->assertEquals(ProposalResponse::STATUS_FINAL_VALIDATION, $proposal_response->status);

        $this->assertDatabaseHas('addworking_common_comments', [
            'commentable_id' => $proposal_response->id,
        ]);
    }

    /**
     * @dataProvider proposalResponseCloseOfferFormData
     */
    public function testChangeResponseStatusCanCloseOffer($data)
    {
        $proposal_response = factory(ProposalResponse::class)->states('pending')->create();
        $proposal_response->proposal->offer->update(['status' => Offer::STATUS_COMMUNICATED]);

        Arr::set($data, 'comment.commentable_id', $proposal_response->id);

        $response = $this
            ->actingAs($proposal_response->proposal->offer->createdBy)
            ->post($proposal_response->routes->status, $data);

        $proposal_response->refresh();

        $this->assertTrue($proposal_response->proposal->offer->isClosed());

        $response->assertRedirect(
            route(
                'enterprise.offer.summary',
                [$proposal_response->proposal->offer->customer, $proposal_response->proposal->offer]
            )
        );
    }

    public function proposalResponseChangeStatusFormData()
    {
        return [
            'change-status' => [
                'data' => [
                    'response' => [
                        'status' => ProposalResponse::STATUS_FINAL_VALIDATION
                    ],
                    'comment' => [
                        'commentable_id'   => null,
                        'commentable_type' => 'proposal_response',
                        'content'          => 'some comment',
                        'visibility'       => Comment::VISIBILITY_PROTECTED
                    ],
                ],
            ],
        ];
    }

    public function proposalResponseCloseOfferFormData()
    {
        return [
            'close-offer' => [
                'data' => [
                    'response' => [
                        'status' => ProposalResponse::STATUS_FINAL_VALIDATION
                    ],
                    'comment' => [
                        'commentable_id'   => null,
                        'commentable_type' => 'proposal_response',
                        'content'          => 'some comment',
                        'visibility'       => Comment::VISIBILITY_PROTECTED
                    ],
                    'close_mission_offer'  => true,
                ],
            ],
        ];
    }
}
