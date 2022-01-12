<?php

namespace Components\Enterprise\Enterprise\Application\Repositories;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Notifications\Addworking\Enterprise\VendorNoncomplianceNotification;
use App\Repositories\Addworking\Enterprise\ComplianceEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\DocumentRepository;
use App\Repositories\Addworking\Enterprise\DocumentTypeRepository;
use Carbon\Carbon;
use Components\Common\Common\Domain\Interfaces\EntityInterface;
use Components\Enterprise\Enterprise\Domain\Exceptions\VendorHasNoActivityWithThisCustomerException;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class EnterpriseRepository implements EnterpriseRepositoryInterface
{
    public function find(string $uuid): EnterpriseEntityInterface
    {
        return Enterprise::findOrFail($uuid);
    }

    public function findBySiret(string $siret)
    {
        return Enterprise::where('identification_number', $siret)->first();
    }

    public function findByIds(array $ids): EnterpriseCollection
    {
        return Enterprise::find($ids);
    }

    public function make($data = []): EnterpriseEntityInterface
    {
        return new Enterprise($data);
    }

    public function isVendor(Enterprise $enterprise): bool
    {
        return $enterprise->is_vendor;
    }

    public function save(EntityInterface $entity): bool
    {
        if (! $entity instanceof EnterpriseEntityInterface) {
            throw new \RuntimeException("unable to save an instance of " . get_class($entity));
        }

        if ($entity instanceof Model) {
            $entity->save();
        }

        throw new \RuntimeException("not implemented");
    }

    public function list(
        ?array $filter = null,
        ?string $search = null,
        ?string $page,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return Enterprise::query()
            ->with(['legalForm', 'legalRepresentatives', 'phoneNumbers', 'activities:field,activity'])
            ->when($filter['legal_form'] ?? null, function ($query, $legal_form) {
                return $query->ofLegalForm($legal_form);
            })
            ->when($filter['type'] ?? null, function ($query, $type) {
                return $query->ofType($type);
            })
            ->when($filter['activity_field'] ?? null, function ($query, $field) {
                return $query->ofActivityField($field);
            })
            ->when($filter['activity'] ?? null, function ($query, $activity) {
                return $query->ofActivity($activity);
            })
            ->when($filter['main_activity_code'] ?? null, function ($query, $code) {
                return $query->ofMainActivityCode($code);
            })
            ->when($filter['family'] ?? null, function ($query, $family) {
                return $query->filterFamily($family);
            })
            ->when($search ?? null, function ($query, $search) use ($operator, $field_name) {
                return $query->search($search, $operator, $field_name);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($page ?: 25);
    }

    public function getSearchableAttributes(): array
    {
        return [
            Enterprise::SEARCHABLE_ATTRIBUTE_NAME =>
                'components.enterprise.filters.name',
            Enterprise::SEARCHABLE_ATTRIBUTE_PHONE =>
                'components.enterprise.filters.phone',
            Enterprise::SEARCHABLE_ATTRIBUTE_IDENTIFICATION_NUMBER =>
                'components.enterprise.filters.identification_number',
            Enterprise::SEARCHABLE_ATTRIBUTE_ZIPCODE =>
                'components.enterprise.filters.zipcode',
        ];
    }

    public function checkPartnership(Enterprise $customer, Enterprise $vendor): bool
    {
        return $customer->vendors->contains($vendor);
    }

    public function checkPartnershipActivity(Enterprise $customer, Enterprise $vendor): bool
    {
        return $vendor->vendorInActivityWithCustomer($customer);
    }

    private function isReadyForTheCustomer(Enterprise $vendor, Enterprise $customer, string $document_type = null): bool
    {
        return DocumentType::ofLegalForm($vendor->legalForm)
            ->requiredByCustomer($customer)
            ->mandatory()
            ->when($document_type, fn($query, $type) => $query->ofType($type))
            ->get()
            ->every(fn($type) => $vendor->documents()->ofDocumentType($type)->onlyPendingOrValidated()->exists());
    }

    public function isCompliantFor(Enterprise $vendor, Enterprise $customer): bool
    {
        $addworking = Enterprise::where('name', 'ADDWORKING')->first();

        return
            $this->isReadyForTheCustomer($vendor, $addworking, DocumentType::TYPE_LEGAL)
            &&
            $this->isReadyForTheCustomer($vendor, $customer, DocumentType::TYPE_LEGAL);
    }
}
