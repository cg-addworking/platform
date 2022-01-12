<?php

namespace Tests\Unit\Foundation\Model\ViewableTest;

use Components\Infrastructure\Foundation\Application\Model\Viewable;

class Beta
{
    use Viewable;

    public $bar;

    protected $viewPrefix = "test::beta";
}
