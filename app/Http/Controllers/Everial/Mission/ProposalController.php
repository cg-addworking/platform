<?php

namespace App\Http\Controllers\Everial\Mission;

use App\Http\Controllers\Addworking\Mission\ProposalController as Controller;

class ProposalController extends Controller
{
    protected $redirects = [
        'store'  => "everial.mission-offer.show",
    ];
}
