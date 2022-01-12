<?php

namespace Tests\Unit\App\Models\Everial\Mission;

use App\Models\Everial\Mission\Referential;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class ReferentialTest extends ModelTestCase
{
    protected $class = Referential::class;

    public function testScopeSearch()
    {
        $referential = factory(Referential::class)->create([
            'shipping_site'       => 'foo bar',
            'shipping_address'    => 'baz quxx',
            'destination_site'    => 'corge grault',
            'destination_address' => 'garply waldo',
        ]);

        $this->assertEquals(
            1,
            Referential::search('fo')->count(),
            'We should find the referential by shipping_site'
        );

        $this->assertEquals(
            1,
            Referential::search('qux')->count(),
            'We should find the referential by shipping_address'
        );

        $this->assertEquals(
            1,
            Referential::search('cor')->count(),
            'We should find the referential by destination_site'
        );

        $this->assertEquals(
            1,
            Referential::search('wal')->count(),
            'We should find the referential by destination_address'
        );

        $this->assertEquals(
            0,
            Referential::search('dingo')->count(),
            'We should find 0 referential by this search term'
        );
    }
}
