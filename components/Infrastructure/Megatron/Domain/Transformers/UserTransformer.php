<?php

namespace Components\Infrastructure\Megatron\Domain\Transformers;

use Components\Infrastructure\Megatron\Domain\Classes\TransformerInterface;
use Faker\Provider\fr_FR\Internet;
use Faker\Provider\fr_FR\Person;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTransformer implements TransformerInterface
{
    const DEFAULT_PASSWORD = 'password';

    /** @var Person */
    protected $person;

    public function __construct(Person $person, Internet $internet)
    {
        $this->person   = $person;
    }

    public function transform(array $user): array
    {
        if (Str::endsWith($user['email'], '@addworking.com')) {
            return [];
        }

        return [
            'email'     => uniqid() . '@gmail.com',
            'password'  => Hash::make(self::DEFAULT_PASSWORD),
            'firstname' => $this->person->firstName($user['gender']),
            'lastname'  => $this->person->lastName(),
        ];
    }
}
