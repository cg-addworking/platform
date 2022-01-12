<?php

namespace Tests\Unit\App\Models\Addworking\Enterprise;

use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class EnterpriseCollectionTest extends TestCase
{
    use RefreshDatabase;

    public function testVendors()
    {
        $rootEnterprise = factory(Enterprise::class)->states('customer')->create();
        foreach (factory(Enterprise::class, 5)->states('customer')->create() as $child) {
            foreach (factory(Enterprise::class, 10)->states('vendor')->create() as $vendor) {
                $child->vendors()->syncWithoutDetaching($vendor->id);
            }
            $child->parent()->associate($rootEnterprise)->save();
        }

        $this->assertEquals(
            50,
            $rootEnterprise->family()->vendors()->count(),
            "There should be exactly 50 vendors"
        );
    }

    public function testJobs()
    {
        $enterprises = tap(factory(Enterprise::class, 4)->create(), function ($enterprises) {
            $enterprises->each(function ($enterprise) {
                factory(Job::class, 5)->make()->each(function ($job) use ($enterprise) {
                    $job->enterprise()->associate($enterprise)->save();
                });
            });
        });

        $this->assertEquals(
            20,
            $enterprises->jobs()->count(),
            "There should be exactly 20 jobs"
        );
    }

    /**
     * @dataProvider ancestorsDataProvider
     */
    public function testAncestors($enterprises, $names, $include_self, $expected)
    {
        foreach ($enterprises as $enterprise) {
            tap(
                factory(Enterprise::class)->create(Arr::except($enterprise, 'parent')),
                function ($created) use ($enterprise) {
                    if (isset($enterprise['parent'])) {
                        $created->parent()->associate(Enterprise::fromName($enterprise['parent']))->save();
                    }
                }
            );
        }

        $collection = EnterpriseCollection::wrap(array_map(fn($name) => Enterprise::fromName($name), $names));

        $this->assertEquals(
            $expected,
            $collection->ancestors($include_self)->count(),
            "The ancestors collection should include {$include_self} items"
        );
    }

    public function ancestorsDataProvider()
    {
        return [
            '3 roots and 6 children (self not included)' => [
                'enterprises' => [
                    ['name' => "ENT_A"],
                    ['name' => "ENT_A_1",   'parent' => 'ENT_A'],
                    ['name' => "ENT_A_1_1", 'parent' => 'ENT_A_1'],

                    ['name' => "ENT_B"],
                    ['name' => "ENT_B_1",   'parent' => 'ENT_B'],
                    ['name' => "ENT_B_1_1", 'parent' => 'ENT_B_1'],

                    ['name' => "ENT_C"],
                    ['name' => "ENT_C_1",   'parent' => 'ENT_C'],
                    ['name' => "ENT_C_1_1", 'parent' => 'ENT_C_1'],
                ],
                'names' => [
                    'ENT_A_1_1',
                    'ENT_B_1_1',
                    'ENT_C_1_1'
                ],
                'include_self' => false,
                'expected' => 6,
            ],

            '3 enterprises sharing a common ancestor (self not included)' => [
                'enterprises' => [
                    ['name' => "ENT_A"],
                    ['name' => "ENT_A_1",   'parent' => 'ENT_A'],
                    ['name' => "ENT_A_1_1", 'parent' => 'ENT_A_1'],

                    ['name' => "ENT_B_1",   'parent' => 'ENT_A'],
                    ['name' => "ENT_B_1_1", 'parent' => 'ENT_B_1'],

                    ['name' => "ENT_C_1",   'parent' => 'ENT_A'],
                    ['name' => "ENT_C_1_1", 'parent' => 'ENT_C_1'],
                ],
                'names' => [
                    'ENT_A_1_1',
                    'ENT_B_1_1',
                    'ENT_C_1_1'
                ],
                'include_self' => false,
                'expected' => 4,
            ],

            'a loooong chain' => [
                'enterprises' => [
                    ['name' => "ENT_A"],
                    ['name' => "ENT_B", 'parent' => "ENT_A"],
                    ['name' => "ENT_C", 'parent' => "ENT_B"],
                    ['name' => "ENT_D", 'parent' => "ENT_C"],
                    ['name' => "ENT_E", 'parent' => "ENT_D"],
                    ['name' => "ENT_F", 'parent' => "ENT_E"],
                    ['name' => "ENT_G", 'parent' => "ENT_F"],
                    ['name' => "ENT_H", 'parent' => "ENT_G"],
                    ['name' => "ENT_I", 'parent' => "ENT_H"],
                    ['name' => "ENT_J", 'parent' => "ENT_I"],
                ],
                'names' => [
                    'ENT_J',
                ],
                'include_self' => false,
                'expected' => 9,
            ],

            '2 roots and 4 children (self included)' => [
                'enterprises' => [
                    ['name' => "ENT_A"],
                    ['name' => "ENT_A_1",   'parent' => 'ENT_A'],
                    ['name' => "ENT_A_1_1", 'parent' => 'ENT_A_1'],

                    ['name' => "ENT_B"],
                    ['name' => "ENT_B_1",   'parent' => 'ENT_B'],
                    ['name' => "ENT_B_1_1", 'parent' => 'ENT_B_1'],
                ],
                'names' => [
                    'ENT_A_1_1',
                    'ENT_B_1_1',
                ],
                'include_self' => true,
                'expected' => 6,
            ],
        ];
    }
}
