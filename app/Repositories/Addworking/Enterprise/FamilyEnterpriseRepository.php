<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Database\Eloquent\Collection;

class FamilyEnterpriseRepository implements RepositoryInterface
{
    public function getCustomerGroups()
    {
        return Enterprise::with(['parent', 'children', 'vendors', 'customers'])
            ->ofType('customer')
            ->has('children')
            ->doesntHave('parent')
            ->get()
            ->mapWithKeys(fn($enterprise) => [$enterprise->name => $this->getFamily($enterprise)])
            ->sortByDesc(fn($group) => count($group));
    }

    public function getAllCustomersAndAncestors(Enterprise $enterprise): Collection
    {
        return new Collection(
            $enterprise->customers->map(fn($enterprise) => $this->getAncestors($enterprise, true))
                ->flatten()->unique('id')
        );
    }

    public function getDescendants(Enterprise $enterprise, bool $include_self = false): Collection
    {
        $descendants = $enterprise->children->reduce(
            fn($carry, $child) => $carry->push($child)->merge($this->getDescendants($child)),
            $enterprise->newCollection()
        );

        if ($include_self) {
            $descendants->push($enterprise);
        }

        return $descendants;
    }

    public function getAncestors(Enterprise $enterprise, bool $include_self = false): Collection
    {
        $ancestors = $enterprise->parent->exists
            ? $this->getAncestors($enterprise->parent)->push($enterprise->parent)
            : $enterprise->newCollection();

        if ($include_self) {
            $ancestors->push($enterprise);
        }

        return $ancestors;
    }

    public function getFamily(Enterprise $enterprise): Collection
    {
        $root = $enterprise;

        while ($root->parent->exists) {
            $root = $root->parent;
        }

        return $this->getDescendants($root)->prepend($root);
    }

    public function areFromSameFamily(Enterprise $a, Enterprise $b): bool
    {
        return $a->family()->contains($b);
    }
}
