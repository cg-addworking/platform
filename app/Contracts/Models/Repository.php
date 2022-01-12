<?php

namespace App\Contracts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * Find a model.
     *
     * @param  Model|string $id
     * @return Model
     */
    public function find($id): Model;

    /**
     * List available models.
     *
     * @param  string $search
     * @param  array $filter
     * @return Builder
     */
    public function list(?string $search = null, ?array $filter = null): Builder;

    /**
     * Make a new model but do not save it!
     *
     * @param  array $data
     * @return Model
     */
    public function make($data): Model;

    /**
     * Create a new model.
     *
     * @param  array $data
     * @return Model
     */
    public function create($data): Model;

    /**
     * Update a model.
     * @param  Model|string $id
     * @param  array $data
     * @return boolean
     */
    public function update($id, $data): bool;

    /**
     * Delete a model.
     *
     * @param  Model|string $id
     * @return boolean
     */
    public function delete($id): bool;
}
