<?php

namespace Components\Infrastructure\Foundation\Application\Http\Controller;

use Illuminate\Http\Request;

trait HandlesPagination
{
    /**
     * page input name.
     *
     * @var string
     */
    protected $pageInput = "page";

    /**
     * per page input name.
     *
     * @var string
     */
    protected $perPageInput = "per-page";

    /**
     * Reset input name.
     *
     * @var string
     */
    protected $resetInput = "reset";

    /**
     * Handles the page parameters on request.
     *
     * @param  Request $request
     * @return $this
     */
    public function handlePagination(Request $request)
    {
        $page_key     = class_to_dot(static::class) . '.page';
        $per_page_key = class_to_dot(static::class) . '.per_page';

        if ($request->has($this->resetInput)) {
            $request->session()->forget([$page_key, $per_page_key]);
        }

        $request->has($this->pageInput)
            ? $request->session()->put($page_key, $request->input($this->pageInput))
            : $request[$this->pageInput] = $request->session()->get($page_key);

        $request->has($this->perPageInput)
            ? $request->session()->put($per_page_key, $request->input($this->perPageInput))
            : $request[$this->perPageInput] = $request->session()->get($per_page_key);

        return $this;
    }
}
