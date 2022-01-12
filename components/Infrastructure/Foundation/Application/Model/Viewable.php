<?php

namespace Components\Infrastructure\Foundation\Application\Model;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\HtmlString;
use RuntimeException;

trait Viewable
{
    public function views()
    {
        return new class($this)
        {
            protected $viewable;

            public function __construct($viewable)
            {
                $this->viewable = $viewable;
            }

            public function __get(string $key): View
            {
                return $this->viewable->getView($key);
            }

            public function __call(string $method, array $arguments): View
            {
                return $this->viewable->getView($method, $arguments[0] ?? []);
            }
        };
    }

    public function getViewsAttribute()
    {
        return $this->views();
    }

    public function toHtml()
    {
        return new HtmlString((string) $this->views->html);
    }

    protected function getViewPrefix(): string
    {
        return rtrim($this->viewPrefix ?? class_to_dot(str_after(self::class, 'App\\Models\\')), '.');
    }

    protected function getViewVarName(): string
    {
        return snake_case(class_basename($this));
    }

    public function getView($name, array $arguments = []): View
    {
        $name = ltrim(sprintf('%s._%s', $this->getViewPrefix(), $name), '.');

        if (! ViewFacade::exists($name)) {
            throw new RuntimeException("no such view {$name}");
        }

        return ViewFacade::make($name)->with([$this->getViewVarName() => $this] + $arguments);
    }
}
