<?php

namespace Tests\Unit\Foundation\Model\ViewableTest;

use Components\Infrastructure\Foundation\Application\Model\Viewable;

class Alpha
{
    use Viewable;

    public $foo;

    protected $viewPrefix = "test::alpha";
}
