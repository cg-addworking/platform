<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\Mission;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Mission\ProposalResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ProposalResponseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider proposalResponseCloseOfferFormData
     */
    public function testUpdateResponseStatus($data)
    {
        $proposal_response = factory(ProposalResponse::class)->states('pending')->create();

        Arr::set($data, 'comment.commentable_id', $proposal_response->id);

        $response = $this
            ->actingAs($proposal_response->proposal->offer->createdBy)
            ->post($proposal_response->routes->status, $data);

        $this->assertTrue(
            $proposal_response->refresh()->proposal->offer->isClosed(),
            "Offer should be closed"
        );

        $response->assertRedirect(
            route('enterprise.offer.summary', [
                $proposal_response->proposal->offer->customer,
                $proposal_response->proposal->offer
            ])
        );
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
