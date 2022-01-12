<?php

namespace Components\Infrastructure\Foundation\Application\Http\Controller;

use App\Contracts\Models\Repository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

trait HandlesIndex
{
    use HandlesFilter, HandlesPagination, HandlesSearch, HandlesSortBy;

    public function getRepository($repository): Repository
    {
        $prop = "repository";

        return $repository ?? $this->$prop;
    }

    public function getPaginatorFromRequest(Request $request, ?callable $callback = null, $repository = null): Paginator
    {
        $this
            ->handlePagination($request)
            ->handleSearch($request)
            ->handleFilter($request)
            ->handleSortBy($request);

        return $this->getRepository($repository)
            ->list($request->input($this->searchInput), $request->input($this->filterInput))
            ->when(isset($callback), $callback)
            ->when(isset($request['sort_column']), function ($query) use ($request) {
                $query->orderBy($request['sort_column'], $request['sort_direction'] ?: 'desc');
            })
            ->latest()
            ->paginate($request->input($this->perPageInput) ?: 25);
    }
}
