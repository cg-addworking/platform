<?php
namespace  Components\Sogetrel\Mission\Application\Models\Scopes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait SearchScope
{
    public function scopeSearch($query, string $search, string $operator = null, string $field_name = null)
    {
        switch ($operator) {
            case "like":
                if (Str::contains($field_name, '.')) {
                    $field = explode('.', $field_name);
                    // get last element of $field
                    $search_field_name = end($field);
                    // remove last element of $field_name to get a clean relation
                    $relation = str_replace('.'.$search_field_name, '', $field_name);
                    return $query->whereHas($relation, function ($query) use ($search_field_name, $search) {
                        return $this->getQueryLike($query, $search_field_name, $search);
                    });
                } else {
                    return $this->getQueryLike($query, $field_name, $search);
                }
            case "equal":
                if (Str::contains($field_name, '.')) {
                    $field = explode('.', $field_name);
                    // get last element of $field
                    $search_field_name = end($field);
                    // remove last element of $field_name to get a clean relation
                    $relation = str_replace('.'.$search_field_name, '', $field_name);
                    return $query->whereHas($relation, function ($query) use ($search_field_name, $search) {
                        return $this->getQueryEqual($query, $search_field_name, $search);
                    });
                } else {
                    return $this->getQueryEqual($query, $field_name, $search);
                }
        }
    }

    private function getQueryLike($query, $field_name, $search)
    {
        return $query->where(DB::raw("LOWER(CAST({$field_name} as TEXT))"), 'LIKE', "%".strtolower($search)."%");
    }

    private function getQueryEqual($query, $field_name, $search)
    {
        return $query->where(DB::raw("LOWER(CAST({$field_name} as TEXT))"), '=', strtolower($search));
    }
}
