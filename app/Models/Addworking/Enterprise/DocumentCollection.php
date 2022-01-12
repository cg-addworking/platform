<?php

namespace App\Models\Addworking\Enterprise;

use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Database\Eloquent\Collection;

class DocumentCollection extends Collection
{
    use Viewable;

    protected $viewPrefix = "addworking.enterprise.document_collection";

    public function filterStatus(string $status): self
    {
        return $this->filter(function ($doc) use ($status) {
            return $doc->status == $status;
        });
    }

    public function filterStatuses(array $statuses): self
    {
        return $this->filter(function ($doc) use ($statuses) {
            dump("{$doc->status} : {$statuses}");
            return in_array($doc->status, $statuses);
        });
    }

    public function onlyValidated(): self
    {
        return $this->filterStatus(Document::STATUS_VALIDATED);
    }

    public function onlySelectedStatuses(array $statuses): self
    {
        return $this->filterStatuses($statuses);
    }

    public function onlyPendingOrValidated(): self
    {
        return $this->filterStatus(Document::STATUS_PENDING)
            ->merge(
                $this
                    ->filterStatus(Document::STATUS_VALIDATED)
            );
    }

    public function onlyPending(): self
    {
        return $this->filterStatus(Document::STATUS_PENDING);
    }

    public function onlyOutdated(): self
    {
        return $this->filterStatus(Document::STATUS_OUTDATED);
    }

    public function onlyRejected(): self
    {
        return $this->filterStatus(Document::STATUS_REJECTED);
    }

    public function onlyExpired(): self
    {
        return $this->filter(function ($doc) {
            return $doc->hasExpired();
        });
    }

    public function expireInStrictly(int $days): self
    {
        return $this->filter(function ($doc) use ($days) {
            return $doc->expiresInStrictly($days);
        });
    }

    public function expiredSince(int $days): self
    {
        return $this->filter(function ($doc) use ($days) {
            return $doc->expiredSince($days);
        });
    }

    public function shouldNotify(int $days): self
    {
        return $this->filter(function (Document $doc) use ($days) {
            return $doc->shouldNotify($days);
        });
    }

    public function expireIn(int $days): self
    {
        return $this->filter(function ($doc) use ($days) {
            return $doc->expiresIn($days);
        });
    }

    public function validated(): bool
    {
        return $this->onlyValidated()->count() > 0;
    }

    public function pending(): bool
    {
        return $this->onlyPending()->count() > 0;
    }

    public function outdated(): bool
    {
        return $this->onlyOutdated()->count() > 0;
    }

    public function rejected(): bool
    {
        return $this->onlyRejected()->count() > 0;
    }

    public function nonCompliance(): self
    {
        return $this->filter(function ($doc) {
            return $doc->isInvalid();
        });
    }
}
