<?php

namespace Tests\Unit\App\Repositories\Addworking\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\User\UserRepository;
use Conner\Tagging\TaggingUtility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Addworking\Common\PhoneNumber;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testFind()
    {
        $repository = $this->app->make(UserRepository::class);
        $user = factory(User::class)->create();

        $this->assertTrue($repository->find($user)->is($user));
    }

    public function testList()
    {
        $repository = $this->app->make(UserRepository::class);
        $users = factory(User::class, 3)->create();

        $this->assertEquals($repository->list()->count(), 3);
    }

    public function testCreate()
    {
        $repository = $this->app->make(UserRepository::class);
        $user = factory(User::class)->make();

        $data = $user->toArray();
        $data['password'] = Hash::make('secret');

        $this->assertTrue($repository->create($data) instanceof User);
    }

    public function testUpdate()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $this->assertTrue($repository->update($user, ['firstname' => "Adam"]));
    }

    public function testDelete()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $this->assertTrue($repository->delete($user));
    }


    public function testCreateFromRequest()
    {
        $repository = $this->app->make(UserRepository::class);

        $inputs = [
            'user' => [
                'gender'           => "female",
                'firstname'        => "Dominique",
                'lastname'         => "ALLAIN",
                'email'            => "celine83@example.net",
                'password'         => "secret",
                'password_confirm' => "secret",
                'phone_number'     => factory(PhoneNumber::class)->make(),
            ]
        ];

        $user = $repository->createFromRequest(
            $this->fakeRequest()
                ->setInputs($inputs)
                ->setUser(factory(User::class)->create())
                ->obtain()
        );

        $this->assertInstanceOf(User::class, $user);

        $this->assertTrue(
            $user->exists,
            "A user should have been created"
        );

        $this->assertDatabaseHas(
            (new User)->getTable(),
            [
                'gender'           => "female",
                'firstname'        => "Dominique",
                'lastname'         => "ALLAIN",
                'email'            => "celine83@example.net",
            ],
        );
    }

    public function testUpdateFromRequest()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $inputs = [
            'user' =>  [
                'gender'    => "male",
                'firstname' => "Thomas",
                'lastname'  => "NOEL",
                'email'     => "yfaivre@example.net",
            ]
        ];

        $user = $repository->updateFromRequest(
            $user,
            $this->fakeRequest()
                ->setInputs($inputs)
                ->setUser(factory(User::class)->create())
                ->obtain()
        );

        $this->assertInstanceof(
            User::class,
            $user
        );

        $this->assertTrue(
            $user->exists,
            "A user should have been created"
        );

        $this->assertDatabaseHas(
            (new User)->getTable(),
            [
                'gender'    => "male",
                'firstname' => "Thomas",
                'lastname'  => "NOEL",
                'email'     => "yfaivre@example.net",
            ]
        );
    }


    public function testAddTag()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $repository->addTag($user, 'this is a tag');

        $this->assertDatabaseHas(
            'tagging_tagged',
            [
                'taggable_id' => $user->id,
                'taggable_type' => User::class,
                'tag_name' => "this is a tag",
                'tag_slug' => TaggingUtility::slug("this is a tag"),
            ]
        );
    }

    public function testRemoveTag()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $repository->addTag($user, 'this is a tag');

        $repository->removeTag($user, 'this is a tag');

        $this->assertDatabaseMissing(
            'tagging_tagged',
            [
                'taggable_id' => $user->id,
                'taggable_type' => User::class,
                'tag_name' => "this is a tag",
                'tag_slug' => TaggingUtility::slug("this is a tag"),
            ]
        );
    }

    public function testSwapEnterprise()
    {
        $repository = $this->app->make(UserRepository::class);

        $user = factory(User::class)->create();

        $enterprise = factory(Enterprise::class)->create();

        $enterprise->users()->attach($user, [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => false,
            'primary'                 => true,
        ]);

        $another_enterprise = factory(Enterprise::class)->create();

        $another_enterprise->users()->attach($user, [
            'job_title'               => "CEO",
            'is_signatory'            => true,
            'is_legal_representative' => true,
            'current'                 => false,
            'primary'                 => true,
        ]);

        $this->assertTrue($repository->swapEnterprise($user, $enterprise));
        $this->assertEquals($enterprise->fresh(), $user->getCurrentEnterprise()->fresh());

        $this->assertTrue($repository->swapEnterprise($user, $another_enterprise));
        $this->assertEquals($another_enterprise->fresh(), $user->getCurrentEnterprise()->fresh());
    }
}
