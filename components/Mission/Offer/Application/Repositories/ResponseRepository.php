<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Application\Notifications\AcceptNotification;
use Components\Mission\Offer\Application\Notifications\DeclineNotification;
use Components\Mission\Offer\Application\Notifications\SendCreateResponseNotification;
use Components\Mission\Offer\Domain\Exceptions\ResponseCreationFailedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ResponseRepositoryInterface;
use Illuminate\Support\Facades\Notification;

class ResponseRepository implements ResponseRepositoryInterface
{
    public function make(): ResponseEntityInterface
    {
        return new Response;
    }

    public function save(ResponseEntityInterface $response)
    {
        try {
            $response->save();
        } catch (ResponseCreationFailedException $exception) {
            throw $exception;
        }

        $response->refresh();

        return $response;
    }

    public function findByNumber(string $number): ?ResponseEntityInterface
    {
        return Response::where('number', $number)->first();
    }

    public function createFile($content)
    {
        return File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/devis_%uniq%.pdf")
            ->saveAndGet();
    }

    public function sendAcceptedNotification($user, $offer)
    {
        Notification::send(
            $user,
            new AcceptNotification($offer)
        );
    }

    public function sendDeclinedNotification($user, $offer)
    {
        Notification::send(
            $user,
            new DeclineNotification($offer)
        );
    }

    public function list(
        User $user,
        OfferEntityInterface $offer,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $auth_enterprise = $user->enterprise;
        $restrict = ($auth_enterprise->id !== $offer->getCustomer()->id && ! $user->isSupport());

        return Response::query()
            ->with('offer')
            ->whereHas('offer', function ($query) use ($offer) {
                return $query->where('id', $offer->getId());
            })->when($restrict, function ($query) use ($auth_enterprise) {
                return $query->whereHas('enterprise', function ($query) use ($auth_enterprise) {
                    return $query->where('id', $auth_enterprise->id);
                });
            })->when($filter['status'] ?? null, function ($query, $status) {
                return $query->filterStatus($status);
            })
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->latest()->paginate($page ?? 25);
    }

    public function getSearchableAttributes()
    {
        return [
            ResponseEntityInterface::SEARCHABLE_ATTRIBUTE_ENTERPRISE_NAME =>
                'offer::response.index.search.enterprise_name',
        ];
    }

    public function getAvailableStatuses(bool $trans = false): array
    {
        $translation_base = "offer::response._status";

        $states  = [
            ResponseEntityInterface::STATUS_PENDING => __("{$translation_base}.pending"),
            ResponseEntityInterface::STATUS_ACCEPTED => __("{$translation_base}.accepted"),
            ResponseEntityInterface::STATUS_REFUSED => __("{$translation_base}.refused"),
        ];

        return $trans ? $states : array_keys($states);
    }

    public function hasResponseFor(Enterprise $enterprise, OfferEntityInterface $offer)
    {
        return Response::whereHas('offer', function ($query) use ($offer) {
            return $query->where('id', $offer->getId());
        })->whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->exists();
    }

    public function userEnterpriseIsResponseOwner(User $user, ResponseEntityInterface $response): bool
    {
        return $user->enterprise->is($response->getEnterprise()) ;
    }

    public function sendCreateNotification(ResponseEntityInterface $response)
    {
        Notification::send(
            $response->getOffer()->getReferent(),
            new SendCreateResponseNotification($response)
        );
    }
}
