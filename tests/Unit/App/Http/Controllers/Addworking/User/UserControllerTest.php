<?php

namespace Tests\Unit\App\Http\Controllers\Addworking\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy()
    {
        $auth = factory(User::class)->states('support')->create();
        $user = factory(User::class)->states('non-support')->create();

        $this->actingAs($auth)
            ->delete($user->routes->destroy)
            ->assertRedirect();

        $this->assertDatabaseHas('addworking_user_users', ['email' => $auth->email]);

        $this->assertSoftDeleted('addworking_user_users', ['email' => $user->email]);
    }
}
