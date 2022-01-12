<?php

namespace Components\Infrastructure\Foundation\Application\Http\Controller;

use Illuminate\Http\Request;

trait HandlesFilter
{
    /**
     * filter input name.
     *
     * @var string
     */
    protected $filterInput = "filter";

    /**
     * Reset input name.
     *
     * @var string
     */
    protected $resetInput = "reset";

    /**
     * Handles the filter parameters on request.
     *
     * @param  Request $request
     * @return $this
     */
    public function handleFilter(Request $request)
    {
        $key = class_to_dot(static::class) . '.filter';

        if ($request->has($this->resetInput)) {
            $request->session()->forget($key);
        }

        $request->has($this->filterInput)
            ? $request->session()->put($key, $request->input($this->filterInput))
            : $request[$this->filterInput] = $request->session()->get($key);

        return $this;
    }
}
