<?php

namespace Tests\Unit\App\Repositories\Addworking\Mission;

use App\Models\Addworking\Mission\Proposal;
use App\Repositories\Addworking\Mission\ProposalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProposalRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testIsExpired()
    {
        $repo = $this->app->make(ProposalRepository::class);

        $proposal = factory(Proposal::class)->create(['valid_until' => date('Y-m-d', strtotime('+3 weeks'))]);

        $this->assertFalse($repo->isExpired($proposal), 'The proposal is not expired');

        $proposal->valid_until = date('Y-m-d', strtotime('-2 days'));

        $proposal->save();

        $this->assertTrue($repo->isExpired($proposal), 'The proposal has expired');
    }
}
