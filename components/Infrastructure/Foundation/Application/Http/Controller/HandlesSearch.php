<?php

namespace Components\Infrastructure\Foundation\Application\Http\Controller;

use Illuminate\Http\Request;

trait HandlesSearch
{
    /**
     * Search input name.
     *
     * @var string
     */
    protected $searchInput = "search";

    /**
     * Reset input name.
     *
     * @var string
     */
    protected $resetInput = "reset";

    /**
     * Handles the search parameters on request.
     *
     * @param  Request $request
     * @return $this
     */
    public function handleSearch(Request $request)
    {
        $key = class_to_dot(static::class) . '.search';

        if ($request->has($this->resetInput)) {
            $request->session()->forget($key);
        }

        $request->has($this->searchInput)
            ? $request->session()->put($key, $request->input($this->searchInput))
            : $request[$this->searchInput] = $request->session()->get($key);

        return $this;
    }
}
