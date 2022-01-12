#!/usr/bin/env php
<?php

use App\Console\Kernel;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Spie\Enterprise\ActivitiesCsvLoader;
use App\Models\Spie\Enterprise\CoverageZone;
use App\Models\Spie\Enterprise\CoverageZonesCsvLoader;
use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use App\Models\Spie\Enterprise\Order;
use App\Models\Spie\Enterprise\OrdersCsvLoader;
use App\Models\Spie\Enterprise\Qualification;
use App\Models\Spie\Enterprise\QualificationsCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Loading Spie Data\n", date('Y-m-d H:i:s'), "\n";
echo "-------\n";

echo "Loading Vendors...";
$loader = $app->make(EnterprisesCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('tests/Unit/App/Models/Spie/Enterprise/data/vendors_full.csv')));
//$loader->setFlags(CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS);
$loader->run();
echo " done\n";
printf("%6d ok - %6d errors\n", Enterprise::count(), count($loader->getErrors()));
echo "-------\n";

echo "Loading Coverage Zones...";
$loader = $app->make(CoverageZonesCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('tests/Unit/App/Models/Spie/Enterprise/data/coverage_zones_full.csv')));
//$loader->setFlags(CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS);
$loader->run();
echo " done\n";
printf("%6d ok - %6d errors\n", CoverageZone::count(), count($loader->getErrors()));
echo "-------\n";

echo "Loading Qualifications...";
$loader = $app->make(QualificationsCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('tests/Unit/App/Models/Spie/Enterprise/data/qualifications_full.csv')));
//$loader->setFlags(CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS);
$loader->run();
echo " done\n";
printf("%6d ok - %6d errors\n", Qualification::count(), count($loader->getErrors()));
echo "-------\n";

echo "Loading Orders...";
$loader = $app->make(OrdersCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('tests/Unit/App/Models/Spie/Enterprise/data/orders_full.csv')));
//$loader->setFlags(CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS);
$loader->run();
echo " done\n";
printf("%6d ok - %6d errors\n", Order::count(), count($loader->getErrors()));
echo "-------\n";

echo "Loading Activities...";
$loader = $app->make(ActivitiesCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('tests/Unit/App/Models/Spie/Enterprise/data/activities_full.csv')));
//$loader->setFlags(CsvLoader::IGNORE_FIRST_LINE | CsvLoader::RETHROW_EXCEPTIONS);
$loader->run();
echo " done\n";
printf("%6d ok - %6d errors\n", EnterpriseActivity::count(), count($loader->getErrors()));
echo "-------\n";

echo "Import Done.\n", date("Y-m-d H:i:s"), "\n";
echo "-------\n";
echo "-------\n";
