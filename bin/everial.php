#!/usr/bin/env php
<?php

use App\Console\Kernel;
use App\Models\Everial\Mission\ReferentialCsvLoader;
use App\Models\Everial\Mission\Referential;
use App\Models\Everial\Mission\Price;
use Components\Infrastructure\Foundation\Application\CsvLoader;

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Loading Everial Missions Data\n", date('Y-m-d H:i:s'), "\n";
echo "-------\n";

echo "Loading ...";
$loader = $app->make(ReferentialCsvLoader::class);
$loader->setFile(new SplFileObject(base_path('storage/app/customers/everial/referential_everial.csv')));
$loader->run();
echo " done\n";

printf(
    "%6d mission ok - %6d price ok - %6d errors\n",
    Referential::count(),
    Price::count(),
    count($loader->getErrors())
);

echo "-------\n";
echo "Import Done.\n", date("Y-m-d H:i:s"), "\n";
echo "-------\n";
echo "-------\n";
