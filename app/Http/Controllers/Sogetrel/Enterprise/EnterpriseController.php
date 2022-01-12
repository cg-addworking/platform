<?php

namespace App\Http\Controllers\Sogetrel\Enterprise;

use App\Domain\Sogetrel\Navibat\Client;
use App\Http\Controllers\Addworking\Enterprise\EnterpriseController as Controller;
use App\Http\Requests\Addworking\Enterprise\Enterprise\StoreEnterpriseRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use App\Models\Addworking\User\User;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    public function store(StoreEnterpriseRequest $request)
    {
        $response = parent::store($request);
        $user     = $request->user();

        if ($user->enterprise->exists) {
            $vendor = $user->enterprise;
            foreach ($user->sogetrelPasswork->customers as $customer) {
                if (!$customer->vendors()->get()->contains($vendor)) {
                    $customer->vendors()->attach($vendor, ['activity_starts_at' => Carbon::now()]);
                }
                // add billing deadlines by default.
                $deadlines_by_default = CustomerBillingDeadline::whereHas('enterprise', function ($q) use ($customer) {
                    $q->where('id', $customer->id);
                })->get();

                foreach ($deadlines_by_default as $deadline_by_default) {
                    //attach $deadline_by_default to $vendor
                    $vendor->authorizedDeadlineForVendor()->attach(
                        $deadline_by_default->getDeadline(),
                        ['customer_id' => $customer->id]
                    );
                }
            }
        }

        return $response;
    }

    public function synchronizeNavibat(Enterprise $enterprise)
    {
        $client = new Client;
        $sended = $client->sendVendor($enterprise, $errors);

        return $this->redirectWhen(
            $sended,
            $enterprise->routes->show,
            "Synchronisation terminée",
            "Erreur lors de la Synchronisation : {$errors}"
        );
    }


    public function airtableIframe()
    {
        $this->authorize('showIframeAirtable', Enterprise::class);

        return view('sogetrel.enterprise._iframe_show');
    }

    public function setOracleId(Request $request)
    {
        $request->validate([
            'enterprise_id'    => 'required|uuid|exists:addworking_enterprise_enterprises,id',
        ]);

        if ($request->ajax()) {
            $enterprise = Enterprise::where('id', $request->input('enterprise_id'))->first();

            if ($enterprise->sogetrelData->navibat_sent == true) {
                $enterprise->sogetrelData->update(['oracle_id' => $request->input('oracle_id')]);
            }

            $response = [
                'status' => 200,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
