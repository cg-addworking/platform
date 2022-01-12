<?php

namespace Tests\Unit\App\Models\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testDeletedBy()
    {
        $auth = factory(User::class)->state('support')->create();
        $user = factory(User::class)->create();

        $user->deletedBy()->associate($auth)->save();

        $this->assertDatabaseHas('addworking_user_users', [
            'email'      => $user->email,
            'deleted_by' => $auth->id,
        ]);
    }

    public function testScopeEmail()
    {
        $user = factory(User::class)->create(['email' => 'manager@mycompany.com']);

        $this->assertEquals(
            1,
            User::email('ger@my')->count(),
            'We should find the user by email'
        );

        $this->assertEquals(
            0,
            User::email('foo')->count(),
            'We should find 0 user by this search term'
        );
    }

    public function testScopeFilterEnterprise()
    {
        $enterprise = factory(Enterprise::class)->create(['name' => 'ACME Corp']);

        $this->assertEquals(
            1,
            User::filterEnterprise('cme')->count(),
            'We should find the user by enterprise name'
        );

        $this->assertEquals(
            0,
            User::filterEnterprise('foo')->count(),
            'We should find 0 user by this search term'
        );
    }

    public function testScopeSearch()
    {
        $user = tap(factory(User::class)->create([
            'firstname' => 'John',
            'lastname'  => 'Smith',
            'email'     => 'manager@mycompany.com'
        ]), function ($user) {
            $enterprise = factory(Enterprise::class)->create(['name' => 'ACME Corp']);

            $enterprise->users()->first()->delete();

            $enterprise->users()->attach($user, [
                'job_title'               => "CEO",
                'is_signatory'            => true,
                'is_legal_representative' => true,
                'current'                 => true,
                'primary'                 => true,
            ]);
        });

        $this->assertEquals(
            1,
            User::search('jo')->count(),
            'We should find the user by firstname'
        );

        $this->assertEquals(
            1,
            User::search('smItH')->count(),
            'We should find the user by lastname'
        );

        $this->assertEquals(
            1,
            User::search('ger@my')->count(),
            'We should find the user by email'
        );

        $this->assertEquals(
            1,
            User::search('cOr')->count(),
            'We should find the user by enterprise name'
        );

        $this->assertEquals(
            0,
            User::search('foo')->count(),
            'We should find 0 user by this search term'
        );
    }
}
