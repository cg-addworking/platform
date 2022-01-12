<?php

namespace App\Models\Addworking\Enterprise;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Spie\Enterprise\CsvLoaderCasts;
use App\Notifications\Addworking\User\AccountAutomaticallyCreatedNotification;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use Exception;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use LimitIterator;
use SplFileObject;
use SplObjectStorage;
use stdClass;

class VendorsCsvLoader extends CsvLoader
{
    protected $flags = CsvLoader::IGNORE_FIRST_LINE | CsvLoader::VERBOSE;
    protected $customer;
    protected $taxIdRegex = '/^[a-zA-Z]{2}?[0-9]{11}+$/';
    protected $siretRegex = "/^\d{14}$/";
    public $notifyCreatedUsers = false;

    public function setCustomer(Enterprise $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    public function headers(): array
    {
        return [
            'name',                         // Raison sociale
            'legal_form',                   // Forme légale
            'tax_identification_number',    // N° TVA
            'identification_number',        // Numéro SIRET (Optionnal)
            'external_id',                  // Identifiant externe (Optionnal)
            'address',                      // Adresse ligne 1
            'additionnal_address',          // Adresse ligne 2
            'zipcode',                      // Code postal
            'town',                         // Ville
            'country',                      // pays
            'gender',                       // Civilité
            'firstname',                    // Prénom
            'lastname',                     // Nom
            'email',                        // Email
            'job_title',                    // Fonction
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        // trim all strings and casts empty strings as null
        foreach ($this->headers() as $key) {
            $item->$key = ($str = trim($item->$key)) ? $str : null;
        }

        $item->identification_number = preg_replace('/[^\d]/', '', trim($item->identification_number));
        $item->legal_form            = strtolower($item->legal_form ?? null);
        $item->country               = strtolower($item->country);
        $item->gender                = strtolower($item->gender);
        $item->is_vendor             = true;

        if (! preg_match($this->taxIdRegex, $item->tax_identification_number)) {
            $item->tax_identification_number = null;
        }

        if (! preg_match($this->siretRegex, $item->identification_number)) {
            $item->identification_number = null;
        }

        if (is_null($item->job_title)) {
            $item->job_title = "Gérant";
        }

        $rules = $this->getEnterpriseValidationRules($item)
            + $this->getUserValidationRules()
            + $this->getAddressValidationRules();

        Validator::make((array) $item, $rules)->validate();

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $enterprise = Enterprise::firstOrNew(['name' => $item->name]);
        $enterprise->fill(Arr::only((array) $item, [
            'legal_form', 'tax_identification_number', 'identification_number', 'external_id', 'is_vendor',
        ]))->save();

        if ($item->email && ! User::where('email', $item->email)->exists()) {
            $this->createUser($item, $enterprise);
        }

        $address = Address::firstOrCreate(Arr::only((array) $item, [
            'address', 'additionnal_address', 'zipcode', 'town', 'country'
        ]));

        $enterprise->addresses()->syncWithoutDetaching([$address->id]);

        if ($this->customer) {
            $this->customer->vendors()->syncWithoutDetaching($enterprise);
        }

        return $enterprise->exists;
    }

    protected function createUser(stdClass $item, Enterprise $enterprise): User
    {
        $user = User::create([
            'gender'    => $item->gender,
            'firstname' => $item->firstname,
            'lastname'  => $item->lastname,
            'email'     => $item->email,
            'password'  => Hash::make($password = Str::random(10)),
        ]);

        $user->enterprises()->attach($enterprise, [
            'job_title'               => $item->job_title,

            'primary'                 => true,
            'current'                 => true,

            'is_signatory'            => true,
            'is_legal_representative' => true,
            'is_admin'                => true,
            'is_operator'             => true,
            'is_readonly'             => true,

            'access_to_billing'       => true,
            'access_to_mission'       => true,
            'access_to_contract'      => true,
            'access_to_user'          => true,
            'access_to_enterprise'    => true,
        ]);

        if ($this->notifyCreatedUsers) {
            $user->notify(new AccountAutomaticallyCreatedNotification($user, $password));
        }

        return $user;
    }

    protected function getEnterpriseValidationRules(stdClass $item): array
    {
        return [
            'name'  => [
                "required",
                "string",
                "max:255",
                Rule::unique('addworking_enterprise_enterprises', 'name')->ignore($item->name, 'name')
            ],

            'legal_form'  => [
                "nullable",
                "string",
                "exists:addworking_enterprise_legal_forms,name",
            ],

            'tax_identification_number' => [
                "nullable",
                "string",
                "regex:{$this->taxIdRegex}",
            ],

            'identification_number'     => [
                "required",
                "regex:{$this->siretRegex}",
                Rule::unique('addworking_enterprise_enterprises', 'identification_number')->ignore($item->name, 'name'),
            ],

            'external_id' => [
                "nullable",
                "string",
                "max:255",
            ],
        ];
    }

    protected function getUserValidationRules(): array
    {
        return [
            'gender'                    => ["nullable", "required_with:email", Rule::in(User::getAvailableGenders())],
            'firstname'                 => "nullable|required_with:email|string|max:255",
            'lastname'                  => "nullable|required_with:email|string|max:255",
            'email'                     => "nullable|email",
        ];
    }

    protected function getAddressValidationRules(): array
    {
        return [
            'address'                   => "required|string",
            'additionnal_address'       => "nullable|string",
            'zipcode'                   => "required|string|regex:/\d{5}/",
            'town'                      => "required|string",
            'country'                   => "required|string|regex:/[a-zA-Z]{2}/",
        ];
    }
}
