<?php

namespace Tests\Unit\App\Models\TseExpressMedical\Mission;

use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\MissionTrackingLine;
use App\Models\TseExpressMedical\Mission\MissionCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use SplFileObject;
use Tests\TestCase;

class MissionCsvLoaderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider loaderDataProvider
     */
    public function testRun($file, ?int $flags, int $errors, array $counters)
    {
        $customer = factory(Enterprise::class)->create(['name' => "TSE EXPRESS MEDICAL", 'is_customer' => true]);

        foreach (Arr::wrap($file) as $file) {
            $loader = $this->app->make(MissionCsvLoader::class);
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

        $missions = Mission::whereHas('trackings', function ($query) {
            $query->whereHas('milestone', function ($query) {
                $query->where('starts_at', '2020-01-01 00:00:00')->where('ends_at', '2020-01-31 23:59:59');
            });
        })->where('milestone_type', Milestone::MILESTONE_MONTHLY)->get();

        $this->assertEquals(
            $counters['missions'],
            $missions->count(),
            "{$counters['missions']} missions should have been loaded"
        );

        $this->assertEquals(
            $counters['tracking'],
            Mission::inProgress()->count(),
            "{$counters['missions']} trackings should have 'In Progress' status"
        );

        $this->assertEquals(
            $counters['tracking'],
            MissionTracking::count(),
            "{$counters['tracking']} trackings should have been loaded"
        );

        $this->assertEquals(
            $counters['tracking_line'],
            MissionTrackingLine::count(),
            "{$counters['tracking_line']} tracking lines should have been loaded"
        );
    }

    public function loaderDataProvider()
    {
        return [
            'import-missions' => [
                'file'     => __DIR__ . '/data/mission_tse_express_medical.csv',
                'flags'    => CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS,
                'errors'   => 0,
                'counters' => [
                    'missions'      => 6,
                    'tracking'      => 6,
                    'tracking_line' => 10,
                ],
            ],
        ];
    }
}
