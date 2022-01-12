<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\Mission\MissionCollection;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Common\AddressRepository;
use App\Repositories\Addworking\Common\PhoneNumberRepository;
use App\Repositories\Addworking\Enterprise\Concerns\HandlesCounts;
use App\Repositories\Addworking\Enterprise\Concerns\HandlesPhoneNumbers;
use App\Repositories\Addworking\Enterprise\EnterpriseActivityRepository;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ZipArchive;

class EnterpriseRepository extends BaseRepository
{
    use HandlesCounts, HandlesPhoneNumbers;

    protected $model = Enterprise::class;
    protected $user;
    protected $activity;
    protected $address;
    protected $number;
    protected $invitationRepository;
    protected $family;

    protected $pivot = [
        'is_signatory'            => true,
        'is_legal_representative' => true,
        'is_admin'                => true,
        'access_to_billing'       => true,
        'access_to_mission'       => true,
        'access_to_contract'      => true,
        'access_to_user'          => true,
        'access_to_enterprise'    => true,
    ];

    public function __construct(
        UserRepository               $user,
        EnterpriseActivityRepository $activity,
        AddressRepository            $address,
        PhoneNumberRepository        $number,
        InvitationRepository         $invitationRepository,
        FamilyEnterpriseRepository   $family
    ) {
        $this->user                 = $user;
        $this->activity             = $activity;
        $this->address              = $address;
        $this->number               = $number;
        $this->invitationRepository = $invitationRepository;
        $this->family               = $family;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Enterprise::query()
            ->when($filter['name'] ?? null, function ($query, $enterprise) {
                return $query->ofName($enterprise);
            })
            ->when($filter['type'] ?? null, function ($query, $type) {
                return $query->ofType($type);
            })
            ->when($filter['legal_representative'] ?? null, function ($query, $user) {
                return $query->ofLegalRepresentative($user);
            })
            ->when($filter['phone'] ?? null, function ($query, $phone) {
                return $query->ofPhone($phone);
            })
            ->when($filter['address'] ?? null, function ($query, $address) {
                return $query->ofAddress($address);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->filterCreatedAt($date);
            })
            ->when($filter['updated_at'] ?? null, function ($query, $date) {
                return $query->filterUpdatedAt($date);
            })
            ->when($filter['family'] ?? null, function ($query, $family) {
                return $query->whereIn('id', $this->family->getFamily(Enterprise::fromName($family))->pluck('id'));
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request): Enterprise
    {
        return DB::transaction(function () use ($request) {
            $enterprise = $this->make();
            $enterprise->fill($request->input('enterprise') + ['is_vendor' => true]);
            $enterprise->legalForm()->associate($request->input('enterprise.legal_form_id'))->save();

            if ($request->user()->isSupport()) {
                $enterprise->sectors()->attach($request->input('enterprise.sectors'));
            }

            if (!$request->user()->isSupport()) {
                $this->addUser($enterprise, $request->user());
            }

            $this->addActivity($enterprise, $request->input('enterprise_activity'));
            $this->addAddress($enterprise, $request->input('address'));

            foreach (array_filter(array_wrap($request->input('phone_number'))) as $number) {
                $number['number'] ? $this->addPhoneNumber($enterprise, $number) : null;
            }

            $enterprise->users()->updateExistingPivot(
                $request->user(),
                [
                    'job_title' => $request->get('member')['job_title'],
                    User::IS_VENDOR_COMPLIANCE_MANAGER => true,
                ]
            );

            return $enterprise;
        });
    }

    public function createSubsidiaryFromRequest(Request $request, Enterprise $parent): Enterprise
    {
        $child = $this->createFromRequest($request);

        $child->parent()->associate($parent)->save();

        return $child;
    }

    public function updateFromRequest(Enterprise $enterprise, Request $request): bool
    {
        $this->updateRoles($request, $enterprise);

        $this->removeAddress($enterprise);

        $this->addAddress($enterprise, $request->input('address'));

        if (auth()->user()->isSupport()) {
            $enterprise->update([
                'is_vendor' => $request->has('enterprise.vendor'),
                'is_customer' => $request->has('enterprise.customer'),
                'is_business_plus' => $request->has('enterprise.business_plus'),
                'collect_business_turnover' => $request->has('enterprise.collect_business_turnover'),
            ]);

            $enterprise_sectors = $enterprise->sectors()->get();
            if ($request->has('enterprise.sectors')) {
                $enterprise->sectors()->detach($enterprise_sectors);
                $enterprise->sectors()->attach($request->input('enterprise.sectors'));
            } else {
                $enterprise->sectors()->detach($enterprise_sectors);
            }
        } else {
            /*
             * To prevent HTML disabled inputs bypassing we supercharge
             * them with the stored $enterprise attributes
             */
            $data = $request->input();

            $data['enterprise']['tax_identification_number'] = $enterprise->tax_identification_number;
            $data['enterprise']['identification_number']     = $enterprise->identification_number;
            $data['enterprise']['registration_town']         = $enterprise->registration_town;
            $data['enterprise']['legal_form_id']             = $enterprise->legalForm->id;
            $data['enterprise']['external_id']               = $enterprise->external_id;
            $data['enterprise']['name']                      = $enterprise->name;

            $request->merge($data);
        }

        $enterprise->fill($request->input('enterprise'));
        $enterprise->legalForm()->associate($request->input('enterprise.legal_form_id'));

        $this->updateLogo($request, $enterprise);
        $activity = $enterprise->activity;
        $activity->update($request->input('enterprise_activity'));
        $activity->departments()->sync($request->input('enterprise_activity.departments'));

        return $enterprise->save();
    }

    protected function updateRoles(Request $request, Enterprise $enterprise)
    {
        $signatorieIds = $request->input('enterprise.signatories');
        $legalRepresentativeIds = $request->input('enterprise.legal_representative');
        $memberIds = $enterprise->users->pluck('id')->toArray();

        if (is_array($signatorieIds) && is_array($legalRepresentativeIds)) {
            $enterprise->users()->updateExistingPivot(
                $memberIds,
                ['is_signatory' => false, 'is_legal_representative' => false]
            );

            $enterprise->users()->updateExistingPivot($signatorieIds, ['is_signatory' => true]);

            $enterprise->users()->updateExistingPivot(
                $legalRepresentativeIds,
                ['is_legal_representative' => true]
            );
        }
    }

    protected function updateLogo(Request $request, Enterprise $enterprise)
    {
        if ($request->has('enterprise.logo')) {
            $file = File::from($request->file('enterprise.logo'))
                ->name("/enterprise/{$enterprise->id}/logo/%uniq%-%ts%.%ext%")
                ->saveAndGet();

            $enterprise->logo()->associate($file);
        }
    }

    public function addUser($enterprise, $user, $pivot = [])
    {
        if (is_string($user)) {
            /** @var User $user */
            $user = $this->user->find($user);
        }

        $user->enterprises()->attach($enterprise, $pivot + $this->pivot);

        $this->invitationRepository->checkIfPendingInvitationExistsFor($user, $enterprise);
    }

    public function addActivity($enterprise, $activity)
    {
        if (is_array($activity)) {
            $activity = $this->activity->make($activity);
        }

        if (is_string($activity)) {
            $activity = $this->activity->find($activity);
        }

        $activity->enterprise()->associate($enterprise)->save();
    }

    public function addAddress($enterprise, $address)
    {

        if (is_array($address)) {
            $address = $this->address->create($address);
        }

        if (is_string($address)) {
            $address = $this->address->find($address);
        }

        $address->enterprises()->attach($enterprise);
    }

    public function removeAddress($enterprise)
    {
        $enterprise->address->enterprises()->detach($enterprise);
    }

    public function generateZipFromDocuments(Enterprise $enterprise)
    {
        $documents = $enterprise->documents->onlyValidated();
        $dir_path = storage_path(sprintf("temp/documents_%s", uniqid()));

        if (! is_dir($dir_path)) {
            mkdir($dir_path);
        }

        foreach ($documents as $document) {
            if (count($document->files) == 0) {
                continue;
            }

            if (count($document->files) === 1) {
                $file = $document->files()->first();
                $path = "{$dir_path}/".$document->documentType->display_name.".{$file->extension}";
                if (! file_put_contents($path, $file->content)) {
                    throw new \RuntimeException("unable to write '{$path}'");
                }
            } else {
                $dir_of_docs = $dir_path."/".Str::slug($document->documentType->display_name);
                if (! is_dir($dir_of_docs)) {
                    mkdir($dir_of_docs);
                }
                foreach ($document->files()->get() as $i => $file) {
                    $path_of_file = $dir_of_docs.DIRECTORY_SEPARATOR
                        .$document->documentType->display_name."_part_".$i.".{$file->extension}";
                    if (! file_put_contents($path_of_file, $file->content)) {
                        throw new \RuntimeException("unable to write '{$path_of_file}'");
                    }

                    unset($path_of_file);
                }
            }
        }

        $path_of_zip = storage_path(
            sprintf("temp/%s_documents_%s.zip", date('YmdHis'), Str::slug($enterprise->name))
        );

        $zip_arg = escapeshellarg($path_of_zip);
        $dir_arg = escapeshellarg($dir_path);

        // -r stands for recursive
        // -j stands for junk (forget about paths in Zip archive)
        // -m delete the original files after zipping
        exec($cmd = "zip -m -r -j {$zip_arg} {$dir_arg}", $output, $return_var);

        if (! $return_var == "0") {
            throw new \RuntimeException("unable to run command '{$cmd}'");
        }

        return $path_of_zip;
    }

    public function sanitizeName(string $value): string
    {
        return \Normalizer::normalize(mb_strtoupper(remove_accents($value)));
    }

    public function fromIdentificationNumber(string $number): Enterprise
    {
        return Enterprise::where('identification_number', '=', $number)->firstOrFail();
    }

    public function fromName(string $name): Enterprise
    {
        return Enterprise::where('name', '=', $name)->firstOrFail();
    }

    public function isPartOfDomain(Enterprise $enterprise, Enterprise $customer): bool
    {
        if ($customer->family()->contains($enterprise)) {
            return true;
        }
/*
        if ($customer->family()->vendors()->contains($enterprise)) {
            return true;
        }
*/
        return false;
    }

    public function isPartOfAppDomain(Enterprise $enterprise): bool
    {
        if ($enterprise->isPartOfSogetrelDomain() ||
            $enterprise->isPartOfEdenredDomain() ||
            $enterprise->isPartOfEverialDomain()) {
            return false;
        }

        return true;
    }

    public function hasFinishedOnboardingProcess(Enterprise $enterprise): bool
    {
        if (! $enterprise->users()->exists()) {
            return false;
        }

        foreach ($enterprise->users as $user) {
            if (! $user->onboardingProcesses()->exists()) {
                return false;
            }

            if ($user->onboardingProcesses->contains(fn($process) => $process->complete == true)) {
                return true;
            }
        }

        return false;
    }

    public function hasJobs(Enterprise $enterprise): bool
    {
        $family = $this->family->getAncestors($enterprise, true)->pluck('id');

        return Job::whereHas('enterprise', function ($query) use ($family) {
            return $query->whereIn('id', $family);
        })->count();
    }

    public function getMissions(Enterprise $customer, Enterprise $vendor): MissionCollection
    {
        return $vendor->vendorMissions->where('customer_enterprise_id', $customer->id);
    }

    public function getAvailableContractualizationLanguages(): array
    {
        return ['fr' => 'Français', 'de' => "Allemand", 'en' => "Anglais"];
    }
}
