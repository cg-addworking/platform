<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use App\Repositories\Addworking\Common\AddressRepository;
use App\Repositories\Addworking\Common\PhoneNumberRepository;
use App\Repositories\Addworking\Enterprise\Concerns\HandlesPhoneNumbers;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteRepository extends BaseRepository
{
    use HandlesPhoneNumbers;

    protected $model = Site::class;
    protected $address;
    protected $number;

    public function __construct(AddressRepository $address, PhoneNumberRepository $number)
    {
        $this->address  = $address;
        $this->number   = $number;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Site::query()
            ->when($filter['name'] ?? null, function ($query, $site) {
                return $query->ofName($site);
            })
            ->when($filter['code'] ?? null, function ($query, $code) {
                return $query->ofCode($code);
            })
            ->when($filter['phone'] ?? null, function ($query, $phone) {
                return $query->ofPhone($phone);
            })
            ->when($filter['address'] ?? null, function ($query, $address) {
                return $query->ofAddress($address);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->createdAt($date);
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): Site
    {
        return DB::transaction(function () use ($request, $enterprise) {

            $site = self::make($request->input('site'));
            $site->name = strtolower(remove_accents($request->input('site.display_name')));
            $site->enterprise()->associate($enterprise);

            $site->save();

            $this->addAddress($site, $request->input('address'));

            foreach (array_filter(array_wrap($request->input('phone_number'))) as $number) {
                $number['number'] ? $this->addPhoneNumberToSite($site, $number) : null;
            }

            return $site;
        });
    }

    public function addAddress($site, $address)
    {
        if (is_array($address)) {
            $address = $this->address->create($address);
        }

        if (is_string($address)) {
            $address = $this->address->find($address);
        }

        $address->sites()->attach($site);
    }

    public function updateFromRequest(Request $request, Enterprise $enterprise, Site $site): Site
    {
        return DB::transaction(function () use ($request, $site) {
            $site->update($request->input('site'));
            $site->name = strtolower(remove_accents($request->input('site.display_name')));

            $this->removeAddress($site);
            $this->addAddress($site, $request->input('address'));

            return $site;
        });
    }

    public function removeAddress($site)
    {
        $site->addresses->first()->sites()->detach($site);
    }
}
