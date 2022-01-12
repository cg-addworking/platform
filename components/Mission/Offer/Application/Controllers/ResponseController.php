<?php

namespace Components\Mission\Offer\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Comment;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\UseCases\CloseOffer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Application\Presenters\ResponseListPresenter;
use Components\Mission\Offer\Application\Presenters\ResponseShowPresenter;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Requests\StoreConstructionResponseRequest;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionResponse;
use Components\Mission\Offer\Domain\UseCases\ShowConstructionResponse;
use Components\Mission\Offer\Domain\UseCases\ListResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ResponseController extends Controller
{
    public function create(Offer $offer)
    {
        $this->authorize('create', [Response::class, $offer]);

        return view('offer::response.create', compact('offer'));
    }

    public function store(Offer $offer, StoreConstructionResponseRequest $request)
    {
        $this->authorize('create', [Response::class, $offer]);
        $authenticated = App::make(UserRepository::class)->connectedUser();
        $response = App::make(CreateConstructionResponse::class)->handle(
            $authenticated,
            $offer,
            $request->input('response'),
            $request->file('response.file')
        );

        return $this->redirectWhen($response->exists, route('sector.response.show', [$offer, $response]));
    }

    public function show(Offer $offer, Response $response)
    {
        $this->authorize('show', [$response, $offer]);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $presenter = new ResponseShowPresenter;

        $response = App::make(ShowConstructionResponse::class)
            ->handle($presenter, $authenticated, $response);

        return view('offer::response.show', compact('response'));
    }

    public function accept(Offer $offer, Response $response, Request $request)
    {
        $this->authorize('accept', [$response, $offer]);

        $response->setStatus(ResponseEntityInterface::STATUS_ACCEPTED);
        $updated = App::make(ResponseRepository::class)->save($response);

        if ($request->submit === "accept_close_offer") {
            $authenticated = App::make(UserRepository::class)->connectedUser();
            App::make(CloseOffer::class)->handle($authenticated, $offer);
        }

        return $this->redirectWhen($updated->exists, route('sector.response.show', [$offer, $response]));
    }

    public function reject(Offer $offer, Response $response, Request $request)
    {
        $this->authorize('reject', [$response, $offer]);

        $response->setStatus(ResponseEntityInterface::STATUS_REFUSED);
        $updated = App::make(ResponseRepository::class)->save($response);

        if ($request->filled('content')) {
            $comment = new Comment;
            $comment->content = "Commentaire de refus: ". $request->input('content');
            $comment->visibility = Comment::VISIBILITY_PUBLIC;
            $comment->commentable()->associate($response);
            $comment->author()->associate(App::make(UserRepository::class)->connectedUser());
            $comment->save();
        }

        return $this->redirectWhen($updated->exists, route('sector.response.show', [$offer, $response]));
    }

    public function index(Request $request, Offer $offer)
    {
        $this->authorize('index', [Response::class, $offer]);

        $authenticated = App::make(UserRepository::class)->connectedUser();
        $presenter = new ResponseListPresenter;

        $items = App::make(ListResponse::class)->handle(
            $presenter,
            $authenticated,
            $offer,
            $request->input('filter'),
            $request->input('search'),
            $request->input('per-page'),
            $request->input('operator'),
            $request->input('field')
        );

        $searchable_attributes = App::make(ResponseRepository::class)->getSearchableAttributes();
        $statuses = App::make(ResponseRepository::class)->getAvailableStatuses(true);

        return view('offer::response.index', compact('items', 'offer', 'searchable_attributes', 'statuses'));
    }
}
