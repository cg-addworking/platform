<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Domain\Exceptions\OfferCreationFailedException;
use Components\Mission\Offer\Domain\Interfaces\Entities\OfferEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Entities\ResponseEntityInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;

class OfferRepository implements OfferRepositoryInterface
{
    public function make(): OfferEntityInterface
    {
        return new Offer;
    }

    public function save(OfferEntityInterface $offer)
    {
        try {
            $offer->save();
        } catch (OfferCreationFailedException $exception) {
            throw $exception;
        }

        $offer->refresh();

        return $offer;
    }

    public function findByNumber($number): ?OfferEntityInterface
    {
        return Offer::where('number', $number)->first();
    }

    public function hasAcceptedResponses(OfferEntityInterface $offer): bool
    {
        return Response::whereHas('offer', function ($query) use ($offer) {
            return $query->where('id', $offer->getId());
        })->where('status', ResponseEntityInterface::STATUS_ACCEPTED)->exists();
    }

    public function getAvailableStatuses(bool $trans = false): array
    {
        $translation_base = "offer::offer._status";

        $states  = [
            OfferEntityInterface::STATUS_DRAFT => __("{$translation_base}.draft"),
            OfferEntityInterface::STATUS_TO_PROVIDE => __("{$translation_base}.to_provide"),
            OfferEntityInterface::STATUS_COMMUNICATED => __("{$translation_base}.communicated"),
            OfferEntityInterface::STATUS_CLOSED => __("{$translation_base}.closed"),
            OfferEntityInterface::STATUS_ABANDONED => __("{$translation_base}.abandoned"),
        ];

        return $trans ? $states : array_keys($states);
    }

    public function list(
        User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return Offer::query()
            ->when(! $user->isSupport(), function ($query) use ($user) {
                $query->whereHas('customer', function ($query) use ($user) {
                    return $query->whereIn('id', $user->enterprises()->pluck('id'));
                });
                $query->orWhereHas('proposals', function ($query) use ($user) {
                    return $query->whereHas('vendor', function ($query) use ($user) {
                        return $query->whereIn('id', $user->enterprises()->pluck('id'));
                    });
                });
            })
            ->when($filter['statuses'] ?? null, function ($query, $statuses) {
                return $query->filterStatus($statuses);
            })
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->latest()
            ->paginate($page ?? 25);
    }

    public function getSearchableAttributes(): array
    {
        return [
            OfferEntityInterface::SEARCHABLE_ATTRIBUTE_LABEL => 'offer::offer.index.search.label',
            OfferEntityInterface::SEARCHABLE_ATTRIBUTE_CUSTOMER_NAME => 'offer::offer.index.search.customer_name',
            OfferEntityInterface::SEARCHABLE_ATTRIBUTE_REFERENT_LASTNAME
                => 'offer::offer.index.search.referent_lastname'
        ];
    }

    public function createFiles($files, OfferEntityInterface $offer)
    {
        foreach ($files as $content) {
            $file = File::saveAndSendToStorage($content);
            $offer->files()->attach($file->id);
        }
    }

    public function userEnterpriseIsOfferOwner(User $user, OfferEntityInterface $offer): bool
    {
        return $user->enterprise->is($offer->getCustomer()) ;
    }

    public function isDeleted(string $number): bool
    {
        return is_null(Offer::where('number', $number)->first());
    }

    public function delete(OfferEntityInterface $offer)
    {
        return $offer->delete();
    }

    public function deleteFile(File $file)
    {
        return $file->delete();
    }
}
