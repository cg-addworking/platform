<?php

namespace Tests\Unit\App\Models\Spie\Enterprise;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise as AddworkingEnterprise;
use App\Models\Spie\Enterprise\Enterprise as SpieEnterprise;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use Exception;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use SplFileObject;
use Tests\TestCase;

class EnterpriseCsvLoaderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider loaderDataProvider
     */
    public function testRun($file, ?int $flags, int $errors, array $counters, ?string $exception = null)
    {
        if (! empty($exception)) {
            $this->expectException($exception);
        }

        foreach (Arr::wrap($file) as $file) {
            $loader = $this->app->make(EnterprisesCsvLoader::class);
            $loader->setFile(new SplFileObject($file));

            if (! is_null($flags)) {
                $loader->setFlags($flags);
            }

            $loader->run();
        }

        $this->assertCount(
            $errors,
            $loader->getErrors(),
            "The loader should encounter {$errors} errors"
        );

        $this->assertEquals(
            $counters['addworking_enterprises'],
            AddworkingEnterprise::count(),
            "{$counters['addworking_enterprises']} Addworking enterprises should have been created"
        );

        $this->assertEquals(
            $counters['spie_enterprises'],
            SpieEnterprise::count(),
            "{$counters['spie_enterprises']} Spie enterprises should have been created"
        );

        $this->assertEquals(
            $counters['phone_numbers'],
            PhoneNumber::count(),
            "{$counters['phone_numbers']} phone numbers should have been created"
        );

        foreach (SpieEnterprise::all() as $enterprise) {
            $this->assertTrue(
                $enterprise->enterprise->exists,
                "Spie entreprise should be attached to an Addworking enterprise"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-vendors' => [
                'file' => __DIR__ . '/data/vendors.csv',
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'addworking_enterprises' => 13,
                    'spie_enterprises' => 10,
                    'phone_numbers' => 10,
                ],
            ],

            'import-vendors-fails' => [
                'file' => __DIR__ . '/data/vendors_with_errors.csv',
                'flags' => null,
                'errors' => 2,
                'counters' => [
                    'addworking_enterprises' => 11,
                    'spie_enterprises' => 8,
                    'phone_numbers' => 8,
                ],
            ],

            'import-vendors-rethrows' => [
                'file' => __DIR__ . '/data/vendors_with_errors.csv',
                'flags' => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS,
                'errors' => 0,
                'counters' => [],
                'exception' => Exception::class,
            ],

            'import-vendors-with-transaction' => [
                'file' => __DIR__ . '/data/vendors.csv',
                'flags' => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::USE_TRANSACTION,
                'errors' => 0,
                'counters' => [
                    'addworking_enterprises' => 13,
                    'spie_enterprises' => 10,
                    'phone_numbers' => 10,
                ],
            ],

            'import-vendors-with-transaction-fails' => [
                'file' => __DIR__ . '/data/vendors_with_errors.csv',
                'flags' => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::USE_TRANSACTION,
                'errors' => 2,
                'counters' => [
                    'addworking_enterprises' => 1,
                    'spie_enterprises' => 0,
                    'phone_numbers' => 0,
                ],
            ],

            'import-vendors-with-transaction-fails-and-rethrows' => [
                'file' => __DIR__ . '/data/vendors_with_errors.csv',
                'flags' => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::USE_TRANSACTION | CsvLoader::RETHROW_EXCEPTIONS,
                'errors' => 0,
                'counters' => [],
                'exception' => Exception::class,
            ],

            'import-vendors-and-update' => [
                'file' => [
                    __DIR__ . '/data/vendors.csv',
                    __DIR__ . '/data/vendors_update.csv',
                ],
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'addworking_enterprises' => 13,
                    'spie_enterprises' => 10,
                    'phone_numbers' => 11,
                ],
            ],

        ];
    }
}
