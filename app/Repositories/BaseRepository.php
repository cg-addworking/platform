<?php

namespace App\Repositories;

use App\Contracts\Models\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements Repository
{
    protected $model;

    public function getModelClass(): string
    {
        return $this->model;
    }

    protected function parseId($id)
    {
        if ($id instanceof Model) {
            return $id->getKey();
        }

        return $id;
    }

    public function find($id): Model
    {
        return $this->getModelClass()::findOrFail($this->parseId($id));
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return $this->getModelClass()::query();
    }

    public function make($data = []): Model
    {
        $class = $this->getModelClass();

        return new $class($data);
    }

    public function factory($data = []): Model
    {
        $class = $this->getModelClass();

        return app()->environment('local') ? factory($class)->make($data) : $this->make($data);
    }

    public function create($data): Model
    {
        ($model = $this->make($data))->save();

        return $model;
    }

    public function update($id, $data): bool
    {
        return $this->find($id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->find($id)->delete();
    }
}
