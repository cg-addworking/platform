<?php

namespace Tests\Unit\App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity as Activity;
use App\Models\Spie\Enterprise\ActivitiesCsvLoader;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use SplFileObject;
use Tests\TestCase;

class ActivitiesCsvLoaderTest extends TestCase
{
    use RefreshDatabase;

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
            $loader = $this->app->make(ActivitiesCsvLoader::class);
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
            $counters['activities'],
            Activity::count(),
            "{$counters['activities']} activities should have been loaded"
        );

        foreach (Activity::cursor() as $activity) {
            $this->assertTrue(
                $activity->enterprise->exists,
                "Activity should have an enterprise"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-activities' => [
                'file' => __DIR__ . '/data/activities.csv',
                'flags' => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS,
                'errors' => 0,
                'counters' => [
                    'activities' => 10,
                ],
            ],

            'import-activities-fails' => [
                'file' => __DIR__ . '/data/activities_with_errors.csv',
                'flags' => null,
                'errors' => 2,
                'counters' => [
                    'activities' => 8,
                ],
            ],

            'import-activities-update' => [
                'file' => [
                    __DIR__ . '/data/activities.csv',
                    __DIR__ . '/data/activities_update.csv',
                ],
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'activities' => 11,
                ],
            ],
        ];
    }
}
