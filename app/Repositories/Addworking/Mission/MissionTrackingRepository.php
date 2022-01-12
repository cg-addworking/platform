<?php

namespace App\Repositories\Addworking\Mission;

use App\Contracts\Models\Repository;
use App\Mail\MissionTrackingCreated;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MissionTrackingRepository extends BaseRepository
{
    protected $model = MissionTracking::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return MissionTracking::query()
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($filter['starts_at'] ?? null, function ($query, $startsAt) {
                return $query->startsAt($startsAt);
            })
            ->when($filter['ends_at'] ?? null, function ($query, $endsAt) {
                return $query->endsAt($endsAt);
            })
            ->when($filter['customer'] ?? null, function ($query, $customer) {
                return $query->customerName($customer);
            })
            ->when($filter['vendor'] ?? null, function ($query, $vendor) {
                return $query->vendorName($vendor);
            })
            ->when($filter['mission'] ?? null, function ($query, $mission) {
                return $query->missionLabel($mission);
            })
            ->when($filter['number'] ?? null, function ($query, $number) {
                return $query->missionNumber($number);
            });
    }

    public function createFromRequest(Mission $mission, Request $request): MissionTracking
    {
        $tracking = $this->make();
        $tracking->fill($request->input('tracking'));
        $tracking->status = MissionTracking::STATUS_PENDING;
        $tracking->mission()->associate($mission);
        $tracking->milestone()->associate($request->input('milestone.id'));
        $tracking->save();
        if ($request->has('tracking.file')) {
            foreach ($request->file('tracking.file') as $file) {
                $tracking->attach($file);
            }
        }

        return $tracking;
    }

    public function updateFromRequest(MissionTracking $tracking, Request $request): MissionTracking
    {
        $tracking->fill($request->input('tracking'));
        $tracking->milestone()->associate($request->input('milestone.id'));
        $tracking->save();

        if ($request->has('tracking.file')) {
            $tracking->attachments->each(function ($file) {
                $file->delete();
            });

            foreach ($request->file('tracking.file') as $file) {
                $tracking->attach($file);
            }
        }

        return $tracking;
    }

    public function sendNotificationFromRequest(Request $request, MissionTracking $tracking)
    {
        $users = new Collection;

        if (! Auth::user()->isSupport()) {
            $users = $tracking->mission->vendor->users;

            $tracking->mission->offer->exists ? $users->push($tracking->mission->offer->referent) : null;
        }

        if ($request->filled('tracking_vendor')) {
            $users->push($tracking->mission->vendor->users);
        }

        if ($request->filled('tracking_customer') && $tracking->mission->offer->exists) {
            $users->push($tracking->mission->offer->referent);
        }

        $users = $users->flatten();

        if (count($users) > 0) {
            $mail = new MissionTrackingCreated($tracking->mission, $tracking);

            $users = $users->filter(fn($user) => $user->can('receive', $mail));

            Mail::to($users)->send($mail);
        }
    }
}
