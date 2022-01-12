<?php

namespace App\Http\Controllers\Addworking\Common;

use App\Http\Requests\Addworking\Common\Comment\StoreCommentRequest;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Common\CommentRepository;
use Components\Contract\Contract\Application\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @var CommentRepository
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param CommentRepository $repository
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = $this->repository->createFromRequest($request);

        if ($request->has('comment.users_to_notify')) {
            $this->repository->notifyUsers($request->input('comment.users_to_notify'), $comment);
        }

        return back()->with($comment->exists ? success_status() : error_status());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $deleted = $comment->delete();

        return back()->with($deleted ? success_status() : error_status());
    }

    public function getUsersToNotify(Request $request)
    {
        $contract_table = (new Contract)->getTable();

        $request->validate([
            "contract_id" => "required|uuid|exists:{$contract_table},id",
        ]);

        if ($request->ajax()) {
            $response = [
                'status' => 200,
                'data' => $this->getUsersArray($this->getUsersCollection($request)),
            ];

            return response()->json($response);
        }

        abort(501);
    }

    private function getUsersCollection(Request $request): Collection
    {
        $users = new collection;
        $auth_user = Auth::user();
        $contract = Contract::find($request->input('contract_id'));

        $enterprise = $auth_user->enterprise;

        if ($request->input('visibility') === Comment::VISIBILITY_PROTECTED) {
            // adding user current enterprise members
            $users->push($enterprise->users);
        }

        if ($request->input('visibility') === Comment::VISIBILITY_PUBLIC) {
            // adding contract creator
            $users->push($contract->getCreatedBy());
            // adding user current enterprise members
            $users->push($enterprise->users);
            // adding contract signatories;
            $users->push($this->repository->getContractSignatories($contract));
        }

        // cleaning the collection and keeping only the needed data
        return $users
            ->flatten()
            ->reject(function ($user) use ($auth_user) {
                return is_null($user) || (! is_null($user) && $user->id === $auth_user->id);
            })
            ->filter()
            ->unique('id')
            ->pluck('name', 'id');
    }

    private function getUsersArray(Collection $users_collection): array
    {
        $users_array = [];
        foreach ($users_collection as $id => $name) {
            $connected_user = Auth::user();
            $user = User::find($id);
            if (! is_null($user) && $user->isSupport() && ! $connected_user->isSupport()) {
                $users_array[$id] = 'Addworking';
            } else {
                $users_array[$id] = $name;
            }
        }

        return $users_array;
    }
}
