<?php

namespace Tests\Unit\App\Models\Everial\Mission;

use App\Models\Everial\Mission\Price;
use App\Models\Everial\Mission\Referential;
use App\Models\Everial\Mission\ReferentialCsvLoader;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use SplFileObject;
use Tests\TestCase;

class ReferentialCsvLoaderTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $customer = factory(Enterprise::class)->create(['name' => "EVERIAL", 'is_customer' => true]);
        $vendors = ['SODATRANS', 'AEM', 'ZIEGLER', 'BENITO', 'SODEL', 'TRANS SUD EST', '3D TRANSEUROP', 'ABSOLUTFRET'];

        foreach ($vendors as $vendor) {
            $vendor = factory(Enterprise::class)->create(['name' => $vendor, 'is_vendor' => true]);
            $customer->vendors()->attach($vendor);
        }
    }

    /**
     * @dataProvider loaderDataProvider
     */
    public function testRun($file, ?int $flags, int $errors, array $counters)
    {
        foreach (Arr::wrap($file) as $file) {
            $loader = $this->app->make(ReferentialCsvLoader::class);
            $loader->setFile(new SplFileObject($file));

            if (! is_null($flags)) {
                $flags && $loader->setFlags($flags);
            }

            $loader->run();
        }

        $this->assertCount(
            $errors,
            $loader->getErrors(),
            "The loader should encounter {$errors} errors"
        );

        $this->assertEquals(
            $counters['referential_missions'],
            Referential::count(),
            "{$counters['referential_missions']} missions should have been loaded"
        );

        foreach (Price::cursor() as $price) {
            $this->assertTrue(
                $price->referential->exists,
                "Price should have a mission"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-referential-missions' => [
                'file'     => __DIR__ . '/data/referential_everial.csv',
                'flags'    => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS,
                'errors'   => 0,
                'counters' => [
                    'referential_missions' => 5,
                ],
            ],
        ];
    }
}
