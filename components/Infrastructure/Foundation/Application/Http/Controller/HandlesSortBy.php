<?php

namespace Components\Infrastructure\Foundation\Application\Http\Controller;

use Illuminate\Http\Request;

trait HandlesSortBy
{
    /**
     * sortBy input name.
     *
     * @var string
     */
    protected $sortByInput = "sort-by";

    /**
     * Reset input name.
     *
     * @var string
     */
    protected $resetInput = "reset";

    /**
     * Handles the sortBy parameters on request.
     *
     * @param  Request $request
     * @return $this
     */
    public function handleSortBy(Request $request)
    {
        $key = class_to_dot(static::class) . '.sort_by';

        if ($request->has($this->resetInput)) {
            $request->session()->forget($key);
        }

        if ($request->has($this->sortByInput)) {
            $column    = array_keys($request->input($this->sortByInput, []))[0] ?? 'created_at';
            $direction = $request->input("{$this->sortByInput}.{$column}", "desc");

            $request->session()->put($key, [$column, $direction]);
        }

        if ($request->session()->has($key)) {
            list($column, $direction) = array_wrap($request->session()->get($key, [])) + ['created_at', 'desc'];
            $request['sort-by'] = [$column => $direction];
            $request['sort_column'] = $column;
            $request['sort_direction'] = $direction;
        }

        return $this;
    }
}
