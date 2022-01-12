<?php

namespace Components\Mission\Offer\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\Interfaces\Repositories\SkillRepositoryInterface;
use Illuminate\Support\Facades\App;

class SkillRepository implements SkillRepositoryInterface
{
    public function getSkillsList(Enterprise $enterprise): array
    {
        $jobs = App::make(JobRepository::class)->getJobsOf($enterprise);
        $skills = [];

        foreach ($jobs as $job) {
            foreach ($job->skills as $skill) {
                $skills[$job->display_name][$skill->id] = $skill->display_name;
            }
        }

        return $skills;
    }

    public function getVendorsWithSkills(Enterprise $enterprise, ?array $skills)
    {
        return $enterprise->vendors()
            ->when($skills, function ($query) use ($skills) {
                $query->whereHas('passworks', function ($query) use ($skills) {
                    $query->whereHas('skills', function ($query) use ($skills) {
                        $query->whereIn('id', $skills);
                    });
                });
            })
            ->orderBy('name', 'asc')
            ->get();
    }

    public function hasOfferSkills(Enterprise $enterprise, Offer $offer)
    {
        $skills = $this->getOfferSkills($offer)->pluck('id')->toArray();

        return Enterprise::where('id', $enterprise->id)->whereHas('passworks', function ($query) use ($skills) {
            return $query->whereHas('skills', function ($query) use ($skills) {
                return $query->whereIn('id', $skills);
            });
        })->exists();
    }

    public function getOfferSkillsList(Offer $offer): array
    {
        $skills = [];
        $offerSkills = $this->getOfferSkills($offer);

        foreach ($offerSkills as $skill) {
            $skills[$skill->job->display_name][$skill->id] = $skill->display_name;
        }

        return $skills;
    }

    public function getOfferSkills(Offer $offer)
    {
        return $offer->skills()->get();
    }
}
