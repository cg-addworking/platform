<?php

namespace App\Models\Sogetrel\User;

use Carbon\Carbon;
use Components\Sogetrel\Passwork\Domain\UseCases\CreateAcceptationContractType;
use Components\Sogetrel\Passwork\Domain\UseCases\CreateAcceptationFromPasswork;
use Illuminate\Http\Request;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Common\CommentRepository;
use Illuminate\Support\Facades\Auth;

trait HasStatus
{
    public function statusAccepted(Request $request, Enterprise $enterprise)
    {
        $success = transaction(function () use ($request) {
            $this->acceptedBy()->associate($request->user()->id);
            $this->administrativeManager()->associate($request->administrative_manager);
            $this->administrativeAssistant()->associate($request->administrative_assistant);
            $this->operationalManager()->associate($request->operational_manager);
            $this->contractSignatory()->associate($request->contract_signatory);
            $this->setWorkStartsAtAttribute($request->work_starts_at);
            $this->setDateDueAtAttribute($request->date_due_at);
            $this->contractTypes()->sync($request->contract_types);
            $this->setNeedsDecennialInsurance($request->needs_decennial_insurance === "yes" ? true : false);
            $this->setApplicablePricerSlip($request->applicable_price_slip);
            $this->setBankGuaranteeAmount(
                is_numeric($request->bank_guarantee_amount) ?
                    $request->bank_guarantee_amount :
                    null
            );

            return $this->save();
        });

        $this->customers()->attach($enterprise);

        if ($this->user->enterprise->exists && !$this->user->enterprise->isVendorOf($enterprise)) {
            $enterprise->vendors()->attach($this->user->enterprise, ['activity_starts_at' => Carbon::now()]);
        }

        return $success;
    }

    public function statusAcceptedQueued(Request $request, Enterprise $enterprise)
    {
        $succes = transaction(function () use ($request) {
            $this->acceptedBy()->associate($request->user()->id);

            return $this->save();
        });

        $this->customers()->attach($enterprise);

        if ($this->user->enterprise->exists) {
            $enterprise->vendors()->attach($this->user->enterprise, ['activity_starts_at' => Carbon::now()]);
        }

        return $succes;
    }

    public function statusPrequalified(Request $request)
    {
        return transaction(function () use ($request) {
            $this->preQualifiedBy()->associate($request->user_id);

            return $this->save();
        });
    }

    public function statusRefused(Request $request)
    {
        return $this->refusedBy()->associate($request->user()->id)->save();
    }

    public function statusRejected(Request $request, Enterprise $enterprise)
    {
        return transaction(function () use ($enterprise) {
            $this->customers()->detach($enterprise);

            if ($this->user->enterprise->exists) {
                $enterprise->users()->detach($this->user);
            }
        });
    }

    public function statusBlacklisted(User $user): bool
    {
        return $this->blacklistedBy()->associate($user->id)->save();
    }

    public function isAccepted()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    public function isAcceptedQueued()
    {
        return $this->status == self::STATUS_ACCEPTED_QUEUED;
    }

    public function isRefused()
    {
        return $this->status == self::STATUS_REFUSED;
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }


    public function isBlacklisted()
    {
        return $this->status == self::STATUS_BLACKLISTED;
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PREQUALIFIED,
            self::STATUS_ACCEPTED,
            self::STATUS_ACCEPTED_QUEUED,
            self::STATUS_REFUSED,
            self::STATUS_NOT_RESULTED,
            self::STATUS_BLACKLISTED,
        ];
    }

    public function statusProcessing($request, $passwork)
    {
        return transaction(function () use ($request, $passwork) {
            $passwork->update(['status' => $request->status]);

            $acceptation_comment = null;

            if ($request->comment['content']) {
                $acceptation_comment = app()->make(CommentRepository::class)->createFromRequest($request);
            }

            $enterprise = $request->user()->enterprise->exists ?
                $request->user()->enterprise :
                Enterprise::fromName('SOGETREL');

            switch ($request->status) {
                case Passwork::STATUS_PREQUALIFIED:
                    return $passwork->statusPrequalified($request);
                case Passwork::STATUS_REFUSED:
                    return $passwork->statusRefused($request);
                case Passwork::STATUS_ACCEPTED:
                    if ($passwork->statusAccepted($request, $enterprise)) {
                        $operational_monitoring_data_comment = $this
                            ->operationalMonitoringDataAsComment($request, $passwork);
                        $acceptation = app()
                            ->make(CreateAcceptationFromPasswork::class)
                            ->handle(
                                Auth::user(),
                                $passwork,
                                $operational_monitoring_data_comment,
                                $acceptation_comment
                            );

                        foreach ($passwork->contractTypes as $contract_type) {
                            app()->make(CreateAcceptationContractType::class)->handle($acceptation, $contract_type);
                        }

                        return true;
                    }
                    return false;
                case Passwork::STATUS_ACCEPTED_QUEUED:
                    return $passwork->statusAcceptedQueued($request, $enterprise);
                case Passwork::STATUS_BLACKLISTED:
                    return $passwork->statusBlacklisted($request->user(), $enterprise);
            }
        });
    }

    protected function operationalMonitoringDataAsComment(Request $request, Passwork $passwork)
    {
        $contract_types_data = '';
        foreach ($passwork->contractTypes as $contract_type) {
            $contract_types_data = $contract_types_data . "- {$contract_type->display_name} \n";
        }

        $acceptedBy = $passwork->acceptedBy;
        $needs_decennial_insurance = $passwork->needs_decennial_insurance ? 'Oui' : 'Non';
        $bank_guarantee_amount = $passwork->bank_guarantee_amount ?? 'NC';

        $data =  [
            "comment" => [
                "commentable_id" => $passwork->id,
                "commentable_type" => "passwork",
                "visibility" => "public",
                "content" => "
                    Statut du passwork :  
                    Accepté pour contractualisation par {$acceptedBy->name} - {$acceptedBy->enterprise}\n
                    Informations d'acceptation du passwork :\n
                    Les types de contrats :
                    {$contract_types_data}
                    Date de début de travail :\n".
                    date_iso_to_date_fr($passwork->work_starts_at)."\n
                    Date d'écheance :\n".
                    date_iso_to_date_fr($passwork->date_due_at)."\n
                    Responsable opérationnel :
                    {$passwork->operationalManager->name}\n
                    Assistant(e) administratif :
                    {$passwork->administrativeAssistant->name}\n
                    Responsable administratif (RAG) :
                    {$passwork->administrativeManager->name}\n
                    Signataire du contrat :
                    {$passwork->contractSignatory->name}\n
                    Besoin d'une assurance décennale ? 
                    {$needs_decennial_insurance}\n
                    Bordereau de prix applicable : 
                    {$passwork->applicable_price_slip}\n
                    Montant de la garantie bancaire : 
                    {$bank_guarantee_amount}\n
                "]
        ];

        $request->merge($data);
        return app()->make(CommentRepository::class)->createFromRequest($request);
    }
}
