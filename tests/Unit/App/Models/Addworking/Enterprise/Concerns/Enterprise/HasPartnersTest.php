<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise\Concerns\Enterprise;

use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasPartnersTest extends TestCase
{
    use RefreshDatabase;

    public function testIsMemberOfSogetrelGroup()
    {
        $this->assertFalse(
            factory(Enterprise::class)->create()->isMemberOfSogetrelGroup(),
            "Enterprise that aren't part of Sogetrel familly are also not member of Sogetrel group"
        );

        $root = tap(factory(Enterprise::class)->states('customer')->create(['name' => "SOGETREL"]), function ($parent) {
            factory(Enterprise::class, 5)->states('customer')->create()->each(function ($child) use ($parent) {
                $child->parent()->associate($parent)->save();

                factory(Enterprise::class, 5)->states('customer')->create()->each(function ($grandchild) use ($child) {
                    $grandchild->parent()->associate($child)->save();
                });
            });
        });

        $this->assertCount(
            31,
            $root->family(),
            "The Sogetrel group should consist of 31 enterprises"
        );

        $this->assertTrue(
            Enterprise::fromName('SOGETREL')->isMemberOfSogetrelGroup(),
            "Sogetrel should be member of its own group"
        );

        foreach ($root->family() as $enterprise) {
            $this->assertTrue(
                $enterprise->isMemberOfSogetrelGroup(),
                "Every enterprise of Sogetrel familly should be member of Sogetrel group"
            );
        }
    }
}
