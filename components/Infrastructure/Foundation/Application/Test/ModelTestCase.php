<?php

namespace Components\Infrastructure\Foundation\Application\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ModelTestCase extends TestCase
{
    use RefreshDatabase;

    protected $class;

    public function testCreate()
    {
        $model = factory($this->class)->create();

        $this->assertInstanceOf(
            Model::class,
            $model,
            "Instances of {$this->class} should be Models"
        );

        $this->assertTrue(
            $model->exists,
            "Model should exists after create"
        );

        $this->assertDatabaseHas(
            $model->getTable(),
            [$model->getKeyName() => $model->getKey()]
        );
    }

    public function testFind()
    {
        $model = factory($this->class)->create();
        $fresh = $this->class::find($model->getKey());

        $this->assertTrue(
            $model->exists,
            "Model should exists after find"
        );

        $this->assertTrue(
            $model->is($fresh),
            "Found model should be identical to created model"
        );
    }

    public function testUpdate()
    {
        $model = factory($this->class)->create();
        $other = factory($this->class)->make();

        $this->assertEquals(
            1,
            $model->update($other->getAttributes()),
            "Updating model should change exactly one record"
        );

        $this->assertDatabaseHas(
            $model->getTable(),
            $model->getChanges()
        );
    }

    public function testDelete()
    {
        $model = factory($this->class)->create();

        $model->delete();

        in_array(SoftDeletes::class, class_uses($model))
            ? $this->assertSoftDeleted($model)
            : $this->assertDeleted($model);
    }
}
