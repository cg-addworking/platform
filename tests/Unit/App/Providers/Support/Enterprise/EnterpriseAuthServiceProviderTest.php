<?php

namespace Tests\Unit\App\Providers\Support\Enterprise;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnterpriseAuthServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function testBoot()
    {
        $user = factory(User::class)->state('support')->create();

        $this->assertTrue($user->can('omnisearch'));
    }
}
