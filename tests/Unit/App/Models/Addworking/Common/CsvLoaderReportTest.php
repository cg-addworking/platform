<?php

namespace Tests\Unit\App\Models\Addworking\Common;

use Components\Infrastructure\Foundation\Application\CsvLoader;
use App\Models\Addworking\Common\CsvLoaderReport;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\VendorsCsvLoader;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use IteratorIterator;
use SplFileObject;
use Tests\TestCase;
use Tests\Unit\App\Models\Addworking\Enterprise\VendorCsvLoaderTest;

class CsvLoaderReportTest extends TestCase
{
    use RefreshDatabase;

    public static function createReport(Application $app): CsvLoaderReport
    {
        $file   = __DIR__ . '/../Enterprise/data/vendors_with_errors.csv';
        $label  = "Import";
        $loader = VendorCsvLoaderTest::createLoader($app, $file)->run();
        $report = CsvLoaderReport::create(@compact('label', 'loader'));

        return $report;
    }

    public function testCsvLoaderSerialization()
    {
        $report = self::createReport($this->app);
        $fresh  = CsvLoaderReport::find($report->id);

        $this->assertInstanceOf(
            CsvLoader::class,
            $fresh->loader,
            "The loader pulled from the report should be an instance of CsvLoader"
        );

        $this->assertCount(
            3,
            $fresh->loader->getErrors(),
            "The loader pulled from the report should have exactly 3 errors"
        );

        $this->assertCount(
            10,
            iterator_to_array($fresh->loader->cursor()),
            "The loader pulled from the report should have exactly 10 items"
        );

        $loader = $fresh->loader;
        foreach ($loader->getErrors() as $item) {
            $this->assertInstanceOf(
                Exception::class,
                $loader->getError($item),
                "The loader pulled from the report should have exceptions"
            );
        }
    }

    public function testReportMetrics()
    {
        $report = self::createReport($this->app);

        $this->assertEquals(
            3,
            $report->error_count,
            "The report should have 3 errors"
        );

        $this->assertEquals(
            10,
            $report->line_count,
            "The report should have 10 lines"
        );

        $this->assertEquals(
            3 / 10,
            $report->error_rate,
            "The report should have an error rate of 30%"
        );
    }

    public function testReportErrorsCsvDownload()
    {
        $report = self::createReport($this->app);

        $this->assertTrue(
            file_exists($report->error_csv),
            "The report should be able to deliver a error CSV report as a SplFileObject"
        );

        $this->assertCount(
            4,
            file($report->error_csv),
            "The report errors CSV should contains 4 lines"
        );
    }
}
