<?php

namespace App\Repositories\Addworking\Enterprise\Concerns;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Site;
use Illuminate\Http\Request;

trait HandlesPhoneNumbers
{
    public function addPhoneNumber($enterprise, $number)
    {
        $phone_number = $this->number->create(array_only($number, 'number'));

        $enterprise->phoneNumbers()->detach($phone_number);

        $enterprise->phoneNumbers()->attach($phone_number, array_only($number, 'note'));
    }

    public function addPhoneNumberToSite($site, $number)
    {
        $phone_number = $this->number->create(array_only($number, 'number'));

        $site->phoneNumbers()->detach($phone_number);

        $site->phoneNumbers()->attach($phone_number, array_only($number, 'note'));
    }

    public function attachPhoneNumberFromRequest(Request $request, Enterprise $enterprise) : Enterprise
    {
        $this->addPhoneNumber($enterprise, $request->input('phone_number'));

        return $enterprise;
    }

    public function attachPhoneNumberForSiteFromRequest(Request $request, Site $site) : Site
    {
        $this->addPhoneNumber($site, $request->input('phone_number'));

        return $site;
    }
}
