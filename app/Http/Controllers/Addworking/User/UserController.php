<?php

namespace App\Http\Controllers\Addworking\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\User\User\StoreUserRequest;
use App\Http\Requests\Addworking\User\User\UpdateUserRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\User\UserRepository;
use Components\Infrastructure\Foundation\Application\Http\Controller\HandlesIndex;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use HandlesIndex;

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $items = $this->getPaginatorFromRequest($request, function ($query) use ($request) {
            $query->with('enterprises')->ofNonSupportUser($request->user());
        });

        return view('addworking.user.user.index', @compact('items'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $user = $this->repository->factory();

        return view('addworking.user.user.create', @compact('user'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->repository->createFromRequest($request);

        return redirect_when($user->exists, route("user.show", $user));
    }

    public function show(User $user)
    {
        $this->authorize('show', $user);

        $comments = null;

        if (Auth::user()->isSupport()) {
            $comments = $user->comments;
        }

        return view('addworking.user.user.show', @compact('user', 'comments'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return view('addworking.user.user.edit', @compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        if ($user->email != $request->input('user.email')) {
            $request->validate([
                'user.email' => "required|email|unique:addworking_user_users,email",
            ]);
        }
        
        if ($user->phoneNumbers->first() != $request->input('user.phone_number')) {
            $request->validate([
                'user.phone_number' => 'required|numeric|min:1'
            ]);
        }

        $updated = $this->repository->updateFromRequest($user, $request);

        return redirect_when($updated->exists, route('user.show', $user));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->deletedBy()->associate(Auth::user())->save();

        $deleted = $user->delete();

        $status  = $deleted ? [
            'class'   => "success",
            'icon'    => "check",
            'message' => "Utilisateur {$user->name} supprimé avec succès",
        ] : [
            'class'   => "danger",
            'icon'    => "ban",
            'message' => "Erreur lors de la suppression de l'utilisateur {$user->name}",
        ];

        return $this->redirectWhen($deleted, route('user.index'))->with(@compact('status'));
    }

    public function ajaxExists(Request $request)
    {
        if ($request->ajax()) {
            $res['exists'] = true;
            $res['error']  = false;

            $request->validate([
                'email' => 'required|email',
            ]);

            try {
                $user = User::fromEmail($request->input('email'));

                if (!$user->enterprise->is_vendor) {
                    $res['error'] = true;
                    $res['msg']   = "Cet utilisateur n'est pas un prestataire";
                } else {
                    $res['id'] = $user->id;
                }
            } catch (ModelNotFoundException $e) {
                $res['exists'] = false;
            }

            return response()->json($res);
        }
    }

    public function swapEnterprise(User $user, Enterprise $enterprise)
    {
        $this->authorize('swapEnterprise', [$user, $enterprise]);

        $swapped = $this->repository->swapEnterprise($user, $enterprise);

        return redirect()->back()->with($swapped ? success_status() : error_status());
    }

    public function addTagSoconnext(User $user)
    {
        $this->repository->addtag($user, 'sogetrel.soconnext');

        return redirect_when(true, route('user.show', $user));
    }

    public function removeTagSoconnext(User $user)
    {
        $this->repository->removeTag($user, 'sogetrel.soconnext');

        return redirect_when(true, route('user.show', $user));
    }

    public function activate(User $user)
    {
        $this->authorize('activate', $user);

        $user->is_active = true;

        $activated = $user->save();

        $status  = $activated ? [
            'class'   => "success",
            'icon'    => "check",
            'message' => "Utilisateur {$user->name} a été réactivé avec succès",
        ] : [
            'class'   => "danger",
            'icon'    => "ban",
            'message' => "Erreur lors de l'activation de l'utilisateur {$user->name}",
        ];

        return redirect()->back()->with(@compact('status'));
    }

    public function deactivate(User $user)
    {
        $this->authorize('deactivate', $user);

        $user->is_active = false;

        $deactivated = $user->save();

        $status  = $deactivated ? [
            'class'   => "success",
            'icon'    => "check",
            'message' => "Utilisateur {$user->name} a été désactivé avec succès",
        ] : [
            'class'   => "danger",
            'icon'    => "ban",
            'message' => "Erreur lors de la désactivation de l'utilisateur {$user->name}",
        ];

        return redirect()->back()->with(@compact('status'));
    }
}
