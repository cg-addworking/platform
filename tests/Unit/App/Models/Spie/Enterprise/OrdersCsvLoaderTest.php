<?php

namespace Tests\Unit\App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\EnterprisesCsvLoader;
use App\Models\Spie\Enterprise\Order;
use App\Models\Spie\Enterprise\OrdersCsvLoader;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use SplFileObject;
use Components\Infrastructure\Foundation\Application\Test\DebugsCsvLoaders;
use Tests\TestCase;

class OrdersCsvLoaderTest extends TestCase
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
            $loader = $this->app->make(OrdersCsvLoader::class);
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
            $counters['orders'],
            Order::count(),
            "{$counters['orders']} orders should have been loaded"
        );

        foreach (Order::cursor() as $order) {
            $this->assertTrue(
                $order->enterprise->exists,
                "Order should have an enterprise"
            );
        }
    }

    public function loaderDataProvider()
    {
        return [
            'import-orders' => [
                'file' => __DIR__ . '/data/orders.csv',
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'orders' => 10,
                ],
            ],

            'import-orders-fails' => [
                'file' => __DIR__ . '/data/orders_with_errors.csv',
                'flags' => null,
                'errors' => 2,
                'counters' => [
                    'orders' => 8,
                ],
            ],

            'import-orders-update' => [
                'file' => [
                    __DIR__ . '/data/orders.csv',
                    __DIR__ . '/data/orders_update.csv',
                ],
                'flags' => null,
                'errors' => 0,
                'counters' => [
                    'orders' => 11,
                ],
            ],
        ];
    }
}
