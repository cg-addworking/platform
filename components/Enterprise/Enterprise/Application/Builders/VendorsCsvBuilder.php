<?php

namespace Components\Enterprise\Enterprise\Application\Builders;

use App\Models\Addworking\Contract\Contract;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository;
use Components\Infrastructure\Foundation\Application\CsvBuilder;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\Sogetrel\Enterprise\PassworkEnterpriseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class VendorsCsvBuilder extends CsvBuilder
{
    private $customer;

    private $customerAncestors;

    private $addworking;

    private $askedDocuments = [];

    protected $headers = [
        1  => "Numero SIRET",
        2  => "Nom de l'entreprise",
        3  => "Forme legale",
        4  => "Identifiant client",
        5  => "CA",
        6  => "Liste des membres customer referents",
        7  => "Nom du representant légal",
        8  => "Adresse email",
        9  => "Adresse postale",
        10  => "Code postal",
        11  => "Numero de telephone",
        12  => "Etape de l'onboarding",
        13  => "Statut des documents legaux obligatoires",
        14  => "Passwork",
        15  => "Contrat CPS3 actif avec ce client",
        16  => "Tags",
        17  => "Nombre de missions",
        18  => "Actif",
        19  => "Date de debut d'activite",
        20  => "Date de fin d'activite",
    ];

    protected function normalize(Model $model): array
    {
        return $this->includeContent($model);
    }

    public function includeDocumentTypeHeader(Enterprise $customer)
    {
        $this->customer = $customer;

        $this->addworking = app(AddworkingEnterpriseRepository::class)->getAddworkingEnterprise();

        $customerDocuments = array_merge(
            $this->getAncestorDocumentTypes($this->customer),
            $this
                ->customer
                ->documentTypes()
                ->exceptType(DocumentType::TYPE_INFORMATIVE)
                ->pluck('id', 'display_name')
                ->all()
        );

        $this->askedDocuments = array_merge(
            $this
                ->addworking
                ->documentTypes()
                ->exceptType(DocumentType::TYPE_INFORMATIVE)
                ->pluck('id', 'display_name')
                ->all(),
            $customerDocuments
        );

        $this->headers = array_merge($this->headers, array_keys($this->askedDocuments));
    }

    public function setCustomer(Enterprise $customer)
    {
        $this->customer = $customer;
    }

    protected function getVendorPartnership(Enterprise $vendor)
    {
        return $vendor->customers()->wherePivot('customer_id', $this->customer->id)->first()->pivot;
    }

    protected function includeContent(Enterprise $model): array
    {
        $normalizedData =  [
            1  => $model->identification_number,
            2  => remove_accents($model->name),
            3  => remove_accents($model->legalForm->display_name ?? 'n/a'),
            4  => $this->getExternalId($model),
            5  => $this->getLastYearBusinessTurnover($model),
            6  => $this->getReferentsNames($model),
            7  => $this->getLegalRepresentativesNames($model),
            8  => $this->getLegalRepresentativesEmails($model),
            9  => remove_accents($model->address),
            10  => $model->address->zipcode,
            11  => $this->getPhoneNumbers($model),
            12  => $this->onboardingProcessStatus($model),
            13  => $this->legalDocumentsStatus($model),
            14  => $this->hasPasswork($model),
            15  => $this->hasCPS3Active($model),
            16  => $this->getTags($model),
            17  => $this->getMissions($model),
            18  => $model->vendorInActivityWithCustomer($this->customer),
            19  => $this->getVendorPartnership($model)->activity_starts_at,
            20  => $this->getVendorPartnership($model)->activity_ends_at
        ];

        return array_merge($normalizedData, $this->getStatusOfDocuments($model));
    }

    protected function getLastYearBusinessTurnover(Enterprise $model)
    {
        $turnover = App::make(EnterpriseRepository::class)->getLastYearBusinessTurnover($model);
        if (isset($turnover) && !is_null($turnover)) {
            return $turnover->amount;
        }
        return 'N/A';
    }

    protected function getStatusOfDocuments(Enterprise $model)
    {
        return array_map(function (string $id) use ($model) {
            return ($document = $model->documents()->where('type_id', $id)->first()) ?
                __("status.".$document->status) : __("Manquant");
        }, array_values($this->askedDocuments));
    }

    protected function getExternalId(Enterprise $vendor)
    {
        if ($vendor->isVendorOfSogetrel()) {
            return $vendor->sogetrelData->navibat_id ?? 'n/a';
        }
        return $vendor->external_id ?? 'n/a';
    }

    protected function getReferentsNames(Enterprise $vendor)
    {
        if ($vendor->vendorReferentsOf($this->customer)->count() == 0) {
            return 'n/a';
        }

        $names = [];

        foreach ($vendor->vendorReferentsOf($this->customer)->get() as $referent) {
            $names[] = remove_accents($referent->name);
        }

        return implode("; ", $names);
    }

    protected function getAncestorDocumentTypes(Enterprise $customer)
    {
        $this->customerAncestors = app(FamilyEnterpriseRepository::class)->getAncestors($customer);

        $arrayDocumentTypes = [];
        $documentTypes = [];

        foreach ($this->customerAncestors as $ancestor) {
            $documentTypes[] = $ancestor
                ->documentTypes()
                ->exceptType(DocumentType::TYPE_INFORMATIVE)
                ->pluck('id', 'display_name')
                ->all();
        }

        foreach ($documentTypes as $document) {
            foreach ($document as $key => $value) {
                $arrayDocumentTypes[$key] = $value;
            }
        }

        return $arrayDocumentTypes;
    }

    protected function getPhoneNumbers(Enterprise $model)
    {
        return $model->phoneNumbers()->pluck('number')->join(' ; ');
    }

    protected function onboardingProcessStatus(Enterprise $model)
    {
        $onboarding_processes_status = [];

        foreach ($model->users()->get() as $member) {
            foreach ($member->onboardingProcesses()->cursor() as $onboarding_process) {
                if ($onboarding_process->exists) {
                    $onboarding_processes_status[] = $onboarding_process->complete
                        ? "Onboarding complete"
                        : $onboarding_process->getCurrentStep()->getDisplayName();
                } else {
                    $onboarding_processes_status[] = "Onboarding inexistant";
                }
            }
        }

        return implode("; ", $onboarding_processes_status);
    }

    protected function legalDocumentsStatus(Enterprise $model)
    {
        return ($model->isReadyToWorkFor($this->addworking, DocumentType::TYPE_LEGAL)
            && $model->isReadyToWorkFor($this->customer, DocumentType::TYPE_LEGAL))
            ? "OK" : "NOK";
    }

    protected function hasPasswork(Enterprise $model)
    {
        return (($this->customer->isSogetrelOrSubsidiary() && $model->hasSogetrelPasswork())
            || $model->passworks()->first()) ? "OUI" : "NON";
    }

    protected function hasCPS3Active(Enterprise $model)
    {
        $contracts = Contract::whereHas('contractParties', function ($query) use ($model) {
            return $query->whereHas('enterprise', function ($query) use ($model) {
                return $query->where('id', $model->id);
            });
        })->whereHas('contractParties', function ($query) {
            return $query->whereHas('enterprise', function ($query) {
                return $query->where('id', $this->customer->id);
            });
        })->where('status', Contract::STATUS_ACTIVE);

        return $contracts->exists() ? "OUI" : "NON";
    }

    protected function getTags(Enterprise $model)
    {
        return app(PassworkEnterpriseRepository::class)->hasTagSoconnext($model) ? "Soconnext" : 0;
    }

    protected function getMissions(Enterprise $model)
    {
        $missions = $model->vendorMissions()->get();

        return $missions ? count($missions) : 0;
    }

    protected function getLegalRepresentativesNames(Enterprise $model)
    {
        $names = [];

        foreach ($model->legalRepresentatives as $legalRepresentative) {
            $names[] = remove_accents($legalRepresentative->name);
        }

        return implode("; ", $names);
    }

    protected function getLegalRepresentativesEmails(Enterprise $model)
    {
        $emails = [];

        foreach ($model->legalRepresentatives as $legalRepresentative) {
            $emails[] = $legalRepresentative->email;
        }

        return implode("; ", $emails);
    }
}
