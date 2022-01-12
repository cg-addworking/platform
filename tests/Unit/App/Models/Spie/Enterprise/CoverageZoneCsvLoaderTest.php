<?php

namespace Tests\Unit\App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\CoverageZone;
use App\Models\Spie\Enterprise\CoverageZonesCsvLoader;
use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use IseedAddworkingCommonRegionsTableSeeder;
use IseedAddworkingCommonDepartmentsTableSeeder;
use Illuminate\Support\Arr;
use SplFileObject;
use Components\Infrastructure\Foundation\Application\Test\DebugsCsvLoaders;
use Tests\TestCase;

class CoverageZoneCsvLoaderTest extends TestCase
{
    use RefreshDatabase, DebugsCsvLoaders;

    protected $debug = false;

    public function setUp(): void
    {
        parent::setUp();

        $loader = $this->app->make(EnterprisesCsvLoader::class);
        $loader->setFile(new SplFileObject(__DIR__ . '/data/vendors.csv'));
        $loader->run();
    }

    /**
     * @dataProvider loaderDataProvider
     */
    public function testRun($file, ?int $flags, int $errors, array $counters)
    {
        foreach (Arr::wrap($file) as $file) {
            $loader = $this->app->make(CoverageZonesCsvLoader::class);
            $loader->setFile(new SplFileObject($file));

            if (! is_null($flags)) {
                $flags && $loader->setFlags($flags);
            }

            $loader->run();
            $this->debug($loader);
        }

        $this->assertCount(
            $errors,
            $loader->getErrors(),
            "The loader should encounter {$errors} errors"
        );

        $this->assertEquals(
            $counters['coverage_zones'],
            CoverageZone::count(),
            "{$counters['coverage_zones']} coverage zones should have been loaded"
        );

        foreach (CoverageZone::cursor() as $coverage_zone) {
            $this->assertTrue(
                $coverage_zone->enterprises()->exists(),
                "A coverage zone should have an enterprise"
            );

            $this->assertTrue(
                $coverage_zone->department()->exists(),
                "A coverage zone should have a department"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-coverage-zones' => [
                'file' => __DIR__ . '/data/coverage_zones.csv',
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'coverage_zones' => 10,
                ],
            ],

            'import-coverage-zones-fails' => [
                'file' => __DIR__ . '/data/coverage_zones_with_errors.csv',
                'flags' => null,
                'errors' => 2,
                'counters' => [
                    'coverage_zones' => 8,
                ],
            ],

            'import-coverage-zones-update' => [
                'file' => [
                    __DIR__ . '/data/coverage_zones.csv',
                    __DIR__ . '/data/coverage_zones_update.csv',
                ],
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'coverage_zones' => 11,
                ],
            ],

        ];
    }
}
