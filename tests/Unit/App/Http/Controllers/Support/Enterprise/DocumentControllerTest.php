<?php

namespace Tests\Unit\App\Http\Controllers\Support\Enterprise;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testExport()
    {
        $user = factory(User::class)->state('support')->create();

        $response = $this->actingAs($user)->get('/support/document/export');
        $response->assertStatus(200);
    }
}
