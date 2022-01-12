<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Common\Skill;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PassworkRepository extends BaseRepository
{
    protected $model = Passwork::class;
    protected $enterprise;

    public function __construct(EnterpriseRepository $enterprise)
    {
        $this->enterprise = $enterprise;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Passwork::query()
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->ofVendor($this->enterprise->find($vendor));
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->ofCustomer($this->enterprise->find($customer));
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): Passwork
    {
        $passwork = $this->make();
        $passwork->customer()->associate($request->input('customer.id'));
        $passwork->passworkable()->associate($enterprise);
        $passwork->save();

        return $passwork;
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, Passwork $passwork): Passwork
    {
        $passwork->skills()->detach();

        foreach ($request->input('skill', []) as $id => $pivot) {
            if (array_get($pivot, 'level') != null) {
                $passwork->skills()->attach($id, $pivot);
            }
        }

        return $passwork;
    }

    public function getVendorsPassworksBySkill(Enterprise $enterprise, Skill $skill)
    {
        return Passwork::whereHas('customer', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->whereHas('skills', function ($query) use ($skill) {
            return $query->where('id', $skill->id);
        })->whereHasMorph(
            'passworkable',
            Enterprise::class,
            function ($query) use ($enterprise) {
                return $query->whereIn('id', $enterprise->vendors()->pluck('id'));
            }
        )->get();
    }
}
