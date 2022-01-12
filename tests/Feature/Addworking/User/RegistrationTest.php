<?php

namespace Tests\Feature\Addworking\User;

use App\Events\UserRegistration;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationView()
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('addworking.user.auth.register');
    }

    /**
     * @dataProvider validUserDataProvider
     */
    public function testRegistrationSucceeds(array $data)
    {
        $response = $this->from('/register')->post('/register', $data);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHasNoErrors();

        $this->assertTrue(User::whereEmail($data['email'])->exists());
        $this->assertAuthenticatedAs(User::fromEmail($data['email']));
    }

    /**
     * @dataProvider validUserDataProvider
     */
    public function testRegistrationEvent(array $data)
    {
        Event::fake([
            UserRegistration::class,
        ]);

        $response = $this->from('/register')->post('/register', $data);

        Event::assertDispatched(UserRegistration::class, function ($e) use ($data) {
            return $e->getUser()->is(User::fromEmail($data['email']));
        });
    }

    /**
     * @dataProvider invalidUserDataProvider
     */
    public function testRegistrationFails(array $data, string $errors)
    {
        $password = Str::random(10);
        $user = factory(User::class)->make();

        $data += [
            'gender'                => $user->gender,
            'firstname'             => $user->firstname,
            'lastname'              => $user->lastname,
            'email'                 => $user->email,
            'password'              => $password,
            'password_confirmation' => $password,
            'tos_accepted'          => true,
            'phone_number'          => "0611223344",
        ];

        $response = $this->from('/register')->post('/register', $data);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(Arr::wrap($errors));
    }

    public function validUserDataProvider()
    {
        return [
            'valid-male-user' => [
                'data' => [
                    'gender' => 'male',
                    'firstname' => 'Mike',
                    'lastname' => "HUNT",
                    'email' => "mike.hunt@gmail.com",
                    'phone_number' => "0611223344",
                    'password' => "hello123",
                    'password_confirmation'  => "hello123",
                    'tos_accepted'  => true,
                ],
            ],

            'valid-female-user' => [
                'data' => [
                    'gender' => 'female',
                    'firstname' => 'Jenna',
                    'lastname' => "TOLLS",
                    'email' => "jena.tolls@gmail.com",
                    'phone_number' => "0611223344",
                    'password' => "hello456",
                    'password_confirmation'  => "hello456",
                    'tos_accepted'  => true,
                ],
            ]
        ];
    }

    public function invalidUserDataProvider()
    {
        return [
            'missing-gender' => [
                'data'  => ['gender' => ""],
                'errors' => 'gender',
            ],

            'missing-firstname' => [
                'data'  => ['firstname' => ""],
                'errors' => 'firstname',
            ],

            'missing-lastname' => [
                'data'  => ['lastname' => ""],
                'errors' => 'lastname',
            ],

            'missing-email' => [
                'data'  => ['email' => ""],
                'errors' => 'email',
            ],

            'missing-password' => [
                'data'  => ['password' => ""],
                'errors' => 'password',
            ],

            'missing-tos-accepted' => [
                'data'  => ['tos_accepted' => ""],
                'errors' => 'tos_accepted',
            ],

            'invalid-gender' => [
                'data'  => ['gender' => "invalid-gender"],
                'errors' => 'gender',
            ],

            'invalid-email' => [
                'data'  => ['email' => "invalid-email"],
                'errors' => 'email',
            ],

            'invalid-password' => [
                'data'  => ['password' => "123"],
                'errors' => 'password',
            ],

            'invalid-password-confirmation' => [
                'data'  => ['password' => "foobar", 'password_confirmation' => "foobaz"],
                'errors' => 'password',
            ],
        ];
    }
}
