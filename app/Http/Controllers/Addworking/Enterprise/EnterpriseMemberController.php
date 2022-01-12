<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\Member\StoreEnterpriseMemberRequest;
use App\Http\Requests\Addworking\Enterprise\Member\UpdateEnterpriseMemberRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EnterpriseMemberController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(EnterpriseMemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, Enterprise $enterprise)
    {
        $this->authorize('indexMember', $enterprise);

        // We add the enterprise'id in order to filter on pivot table
        if ($request->has('filter')) {
            $request['filter'] = $request->get('filter') + ['enterprise' => $enterprise->id];
        }

        $items = $this->getPaginatorFromRequest($request, function (Builder $query) use ($enterprise) {
            return $query->whereHas('enterprises', function (Builder $query) use ($enterprise) {
                return $query->where('id', $enterprise->id);
            });
        });

        return view('addworking.enterprise.member.index', compact('enterprise', 'items'));
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('addMember', $enterprise);

        $user = $this->repository->make();

        return view('addworking.enterprise.member.create', compact('enterprise', 'user'));
    }

    public function store(Enterprise $enterprise, StoreEnterpriseMemberRequest $request)
    {
        $this->authorize('addMember', $enterprise);

        $this->repository->createFromRequest($request, $enterprise);

        return redirect(route('addworking.enterprise.member.index', compact('enterprise')));
    }

    public function show(Enterprise $enterprise, User $user)
    {
        $this->authorize('indexMember', $enterprise);

        return view('addworking.enterprise.member.show', compact('enterprise', 'user'));
    }

    public function edit(Enterprise $enterprise, User $user)
    {
        $this->authorize('editMember', $enterprise);

        return view('addworking.enterprise.member.edit', compact('enterprise', 'user'));
    }

    public function update(UpdateEnterpriseMemberRequest $request, Enterprise $enterprise, User $user)
    {
        $this->authorize('editMember', $enterprise);

        $user = $this->repository->updateFromRequest($request, $enterprise, $user);

        return view('addworking.enterprise.member.show', compact('enterprise', 'user'));
    }

    public function remove(Enterprise $enterprise, User $user)
    {
        $this->authorize('removeMember', [$enterprise, $user]);

        $enterprise->users()->detach($user);

        if (! $user->getCurrentEnterprise()->exists && $user->enterprises->count() > 0) {
            $user->enterprises()->updateExistingPivot($user->enterprises->first(), ['current' => true]);
        }

        return redirect(route('addworking.enterprise.member.index', compact('enterprise')));
    }
}
