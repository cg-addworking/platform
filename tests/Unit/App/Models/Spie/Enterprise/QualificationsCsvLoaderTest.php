<?php

namespace Tests\Unit\App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use App\Models\Spie\Enterprise\Qualification;
use App\Models\Spie\Enterprise\QualificationsCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use SplFileObject;
use Components\Infrastructure\Foundation\Application\Test\DebugsCsvLoaders;
use Tests\TestCase;

class QualificationsCsvLoaderTest extends TestCase
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
            $loader = $this->app->make(QualificationsCsvLoader::class);
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
            $counters['qualifications'],
            Qualification::count(),
            "{$counters['qualifications']} qualifications should have been loaded"
        );

        foreach (Qualification::cursor() as $qualification) {
            $this->assertTrue(
                $qualification->enterprise->exists,
                "Qualifications zone should have an enterprise"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-qualifications' => [
                'file' => __DIR__ . '/data/qualifications.csv',
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'qualifications' => 10,
                ],
            ],

            'import-qualifications-fails' => [
                'file' => __DIR__ . '/data/qualifications_with_errors.csv',
                'flags' => null,
                'errors' => 2,
                'counters' => [
                    'qualifications' => 8,
                ],
            ],

            'import-qualifications-update' => [
                'file' => [
                    __DIR__ . '/data/qualifications.csv',
                    __DIR__ . '/data/qualifications_update.csv',
                ],
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'qualifications' => 11,
                ],
            ],
        ];
    }
}
