<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\VendorsCsvLoader;
use App\Models\Addworking\User\User;
use App\Notifications\Addworking\User\AccountAutomaticallyCreatedNotification;
use Exception;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use SplFileObject;
use SplTempFileObject;
use Components\Infrastructure\Foundation\Application\Test\DebugsCsvLoaders;
use Tests\TestCase;
use stdClass;

class VendorCsvLoaderTest extends TestCase
{
    use RefreshDatabase, DebugsCsvLoaders;

    protected $debug = false;

    public static function createLoader(
        Application $app,
        $file,
        Enterprise $customer = null,
        int $flags = null
    ): CsvLoader {
        $customer = $customer ?? Enterprise::create(['name' => "BIG FKING CORP.", 'is_customer' => true]);
        $flags    = $flags ?? CsvLoader::IGNORE_FIRST_LINE  | CsvLoader::VERBOSE;

        $loader = $app->make(VendorsCsvLoader::class);
        $loader->setFile(is_string($file) ? new SplFileObject($file) : $file);
        $loader->setCustomer($customer);
        $loader->setFlags($flags);

        return $loader;
    }

    /**
     * @dataProvider loaderDataProvider
     */
    public function testRun(
        $file,
        ?int $flags,
        int $errors,
        array $counters,
        array $names = [],
        ?string $exception = null
    ) {
        if (! empty($exception)) {
            $this->expectException($exception);
        }

        $customer = Enterprise::create(['name' => "BIG FKING CORP.", 'is_customer' => true]);

        foreach (Arr::wrap($file) as $file) {
            $this->debug($loader = self::createLoader($this->app, $file, $customer, $flags)->run());
        }

        $this->assertCount(
            $errors,
            $loader->getErrors(),
            "The loader should encounter {$errors} errors"
        );

        $this->assertEquals(
            $counters['enterprises'],
            Enterprise::whereIsVendor()->count(),
            "{$counters['enterprises']} enterprises should have been created"
        );

        $this->assertEquals(
            $counters['enterprises'],
            $customer->vendors()->count(),
            "{$counters['enterprises']} vendors should have been associated to {$customer->name}"
        );

        $this->assertEquals(
            $counters['addresses'],
            Address::count(),
            "{$counters['addresses']} addresses should have been created"
        );

        $this->assertEquals(
            $counters['users'],
            User::count(),
            "{$counters['users']} users should have been created"
        );

        foreach ($names as $name) {
            $this->assertTrue(
                Enterprise::whereName($name)->exists(),
                "a company named {$name} should exist"
            );
        }
    }

    public function testSerialization()
    {
        $this->debug($loader = self::createLoader($this->app, __DIR__ . '/data/vendors_with_errors.csv')->run());

        $flags  = $loader->getFlags();
        $loader = unserialize(serialize($loader));

        $this->assertEquals($flags, $loader->getFlags(), "loader serialization should retain flags state");
        $this->assertCount(3, $loader->getErrors(), "loader serialization should retain error collection");

        foreach ($loader->getErrors() as $item) {
            $this->assertInstanceOf(stdClass::class, $item, "error should retain the reference of items");
            $this->assertInstanceOf(Exception::class, $loader->getError($item), "errors should be exceptions");
        }

        foreach ($loader->cursor() as $item) {
            $this->assertInstanceOf(stdClass::class, $item, "cursor should deliver an iterator of stcClass");
        }

        $this->assertCount(10, iterator_to_array($loader->cursor()), "cursor should deliver 10 items");
    }

    public function testNotifications()
    {
        $vendor_enterprise = factory(Enterprise::class)->make();
        $vendor_user       = factory(User::class)->make();
        $vendor_address    = factory(Address::class)->make();

        $row = [
            // enterprise
            'name'                      => $vendor_enterprise->name,
            'legal_form'                => $vendor_enterprise->legalForm->name,
            'tax_identification_number' => $vendor_enterprise->tax_identification_number,
            'identification_number'     => $vendor_enterprise->identification_number,
            'external_id'               => $vendor_enterprise->external_id,

            // address
            'address'                   => $vendor_address->address,
            'additionnal_address'       => $vendor_address->additionnal_address,
            'zipcode'                   => $vendor_address->zipcode,
            'town'                      => $vendor_address->town,
            'country'                   => $vendor_address->country,

            // user
            'gender'                    => $vendor_user->gender,
            'firstname'                 => $vendor_user->firstname,
            'lastname'                  => $vendor_user->lastname,
            'email'                     => $vendor_user->email,

            // user <> enterprise pivot
            'job_title'                 => "Gérant",
        ];

        $file = new SplTempFileObject;
        $file->fputcsv($row, ';');

        Notification::fake();

        $loader = self::createLoader($this->app, $file, null, 0);
        $loader->notifyCreatedUsers = true;
        $loader->run();

        Notification::assertSentTo(
            User::fromEmail($vendor_user->email),
            AccountAutomaticallyCreatedNotification::class
        );
    }

    public function loaderDataProvider()
    {
        return [
            'import-vendors' => [
                'file' => __DIR__ . '/data/vendors.csv',
                'flags' => null,
                'errors' => 1,
                'counters' => [
                    'enterprises' => 9,
                    'addresses' => 8,
                    'users' => 1,
                ],
                'names' => [
                    "AIS SARL",
                    "AGATE ADDIME",
                    "APAC",
                    "ARDS",
                    "ATOUT PREVENTION",
                    "AQUAPLAST",
                    "(RG)APAC",
                    "BADR SOCIETE",
                    "BVE"
                ]
            ],

            'import-vendors-with-errors' => [
                'file' => __DIR__ . '/data/vendors_with_errors.csv',
                'flags' => null,
                'errors' => 3,
                'counters' => [
                    'enterprises' => 7,
                    'addresses' => 7,
                    'users' => 1,
                ],
                'names' => [
                    "AIS SARL",
                    "AGATE ADDIME",
                    "ARDS",
                    "ATOUT PREVENTION",
                    "AQUAPLAST",
                    "BADR SOCIETE",
                    "BVE"
                ]
            ],

            'import-vendors-with-update' => [
                'file' => [
                    __DIR__ . '/data/vendors.csv',
                    __DIR__ . '/data/vendors_update.csv',
                ],
                'flags' => null,
                'errors' => 1,
                'counters' => [
                    'enterprises' => 9,
                    'addresses' => 9,
                    'users' => 1,
                ],
                'names' => [
                    "AIS SARL",
                    "AGATE ADDIME",
                    "APAC",
                    "ARDS",
                    "ATOUT PREVENTION",
                    "AQUAPLAST",
                    "(RG)APAC",
                    "BADR SOCIETE",
                    "BVE"
                ]
            ],

            'import-soprema-vendors' => [
                'file' => __DIR__ . '/data/soprema_vendors.csv',
                'flags' => null,
                'errors' => 16,
                'counters' => [
                    'enterprises' => 111,
                    'addresses' => 109,
                    'users' => 109,
                ],
            ],
        ];
    }
}
