<?php

namespace Components\Contract\Contract\Application\Jobs;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SendContractToYousignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ContractEntityInterface $contractPartRepository
     */
    protected $contract;

    /**
     * @var string
     */
    protected string $enterprise_language;

    /**
     * @var ContractPartRepositoryInterface $contractPartRepository
     */
    protected $contractPartRepository;

    /**
     * @var ContractRepositoryInterface $contractPartRepository
     */
    protected $contractRepository;

    /**
     * @var ContractPartyRepositoryInterface $contractPartRepository
     */
    protected $contractPartyRepository;

    public function __construct(ContractEntityInterface $contract, string $enterprise_language)
    {
        $this->contract = $contract;
        $this->enterprise_language = $enterprise_language;
        $this->contractPartRepository  = App::make(ContractPartRepository::class);
        $this->contractRepository      = App::make(ContractRepository::class);
        $this->contractPartyRepository = App::make(ContractPartyRepository::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! config('yousign.contract_enabled')) {
            Log::warning("Yousign : you can't sign the contract {$this->contract->getId()}, the system is disabled");
            return;
        }

        if ($this->contract->getstate() !== ContractEntityInterface::STATE_GENERATED) {
            return;
        }

        $contractUrl = env('APP_URL')."/contract/{$this->contract->getId()}";
        $client = new Yousign;

        // Step 1 : create procedure in yousign
        $procedure = $client->startProcedure([
            'name' => str_replace(',', '', $this->contract->getName()),
            'description' => str_replace(',', '', $this->contract->getName()),
            'start' => false,
            'archive' => false,
            'ordered' => true,
            'initials' => config('yousign.initials_enabled'),
            'config' => [
                'email' => [
                    'procedure.finished' => [
                        [
                            'subject' => $this->enterprise_language == 'de'
                                ? 'Die Unterzeichnung Ihres Dokuments, auf AddWorking, ist erledigt.'
                                : 'La signature de votre document est terminée sur AddWorking.',
                            'message' => $client->getFinishedProcedureEmail($contractUrl, $this->enterprise_language),
                            'to' => [
                                '@members'
                            ]
                        ]
                    ],
                    'procedure.refused' => [
                        [
                            'subject' => $this->enterprise_language == 'de'
                                ? 'Die Unterzeichnung Ihres Dokuments, auf AddWorking, wurde abgelehnt.'
                                : 'La signature de votre document a été refusée sur AddWorking.',
                            'message' => $client->getRefusedProcedureEmail($contractUrl, $this->enterprise_language),
                            'to' => [
                                '@members'
                            ]
                        ]
                    ],
                ],
                'webhook' => [
                    'member.finished' => [
                        [
                            'url' => (env('YOUSIGN_WEBHOOK_IN_LOCAL')
                                    ?? env('APP_URL'))."/contract/callback-member-finished",
                            'method' => "GET",
                            'headers' => [
                                'X-Custom-Header' => '761cd088-2f99-41f7-9d29-eb84a6664d52'
                            ]
                        ]
                    ],
                    'procedure.refused' => [
                        [
                            'url' => (env('YOUSIGN_WEBHOOK_IN_LOCAL')
                                    ?? env('APP_URL'))."/contract/callback-procedure-refused",
                            'method' => "GET",
                            'headers' => [
                                'X-Custom-Header' => '761cd088-2f6d-4199-9d29-eb84a6664d52'
                            ]
                        ]
                    ],
                    'procedure.finished' => [
                        [
                            'url' => (env('YOUSIGN_WEBHOOK_IN_LOCAL')
                                    ?? env('APP_URL'))."/contract/callback-procedure-finished",
                            'method' => "GET",
                            'headers' => [
                                'X-Custom-Header' => '761cd088-2f6d-41f7-9d99-eb84a6664d52'
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $this->contract->setYousignProcedureId($procedure->body->id);
        $this->contractRepository->save($this->contract);

        $validator_parties = $this->contractRepository->getValidatorParties($this->contract)->sortBy('order');
        // Step 2 : Add validator parties to procedure
        foreach ($validator_parties as $party) {
            $signatory = $party->getSignatory();
            $member = $client->addMember([
                'position' => $party->getOrder(),
                'firstname' => str_replace(',', '', $signatory->firstname),
                'lastname' => str_replace(',', '', $signatory->lastname),
                'email' => (null !== env('YOUSIGN_TEST_EMAIL_ROOT'))
                    ? env('YOUSIGN_TEST_EMAIL_ROOT')."+".$party->getOrder()."validateur@addworking.com"
                    : $signatory->email,
                'phone' => env('YOUSIGN_TEST_PHONE_NUMBER') ?? '0600000000',
                'procedure' => $procedure->body->id,
                'type' => $client::USER_VALIDATOR,
            ]);

            $party->setYousignMemberId($member->body->id);
            App::make(ContractPartyRepository::class)->save($party);
        }

        if ($this->enterprise_language != 'de') {
            $subject_security_code = 'Signature électronique: Code de sécurité';
            $content_security_code = 'Votre code de sécurité pour signer vos documents est le : {{code}}';
        } else {
            $subject_security_code = 'Digitale Unterschrift: Sicherheitskode';
            $content_security_code = 'Ihrer Sicherheitskode, um Ihre Dokumente zu unterzeichnen, ist : {{code}}';
        }

        $validator_max_order = $this->contractRepository->getMaxOrderofValidator($this->contract);
        $signatory_parties = $this->contractRepository->getSignatoryParties($this->contract)->sortBy('order');
        // Step 3 : Add parties to procedure
        foreach ($signatory_parties as $party) {
            $signatory = $party->getSignatory();
            $member = $client->addMember([
                'position' => $party->getOrder() + $validator_max_order,
                'firstname' => str_replace(',', '', $signatory->firstname),
                'lastname' => str_replace(',', '', $signatory->lastname),
                'email' => (null !== env('YOUSIGN_TEST_EMAIL_ROOT'))
                    ? env('YOUSIGN_TEST_EMAIL_ROOT')."+".$party->getOrder()."@addworking.com"
                    : $signatory->email,
                'phone' => env('YOUSIGN_TEST_PHONE_NUMBER') ?? '0600000000',
                'procedure' => $procedure->body->id,
                'type' => $client::USER_SIGNER,
                'operationLevel' => 'custom',
                'operationCustomModes' => ["email"],
                'operationModeEmailConfig' => [
                    "subject" => $subject_security_code,
                    'content' => $content_security_code,
                ],
            ]);

            $party->setYousignMemberId($member->body->id);
            App::make(ContractPartyRepository::class)->save($party);
        }

        // Step 4 : Add contract part to procedure
        $parts = $this->contractRepository->getContractParts($this->contract)->sortBy('order');
        foreach ($parts as $part) {
            $file = $client->addFile([
                'name' => str_replace(',', '', $part->getDisplayName()),
                'position' => $part->getOrder(),
                'content' => base64_encode($part->getFile()->content),
                'procedure' => $procedure->body->id,
                'type' => $part->getIsSigned() ? $client::FILE_SIGNABLE : $client::FILE_ATTACHMENT
            ]);

            $part->setYousignFileId($file->body->id);
            $this->contractPartRepository->save($part);
        }

        // Step 5 : add signature
        foreach ($parts as $part_sign) {
            if ($part_sign->getIsSigned()) {
                $parties = $this->contractRepository->getSignatoryParties($this->contract)->sortBy('order');
                foreach ($parties as $party) {
                    $fileObject = $client->addSignature([
                        'file' => $part_sign->getYousignFileId(),
                        'member' => $party->getYousignMemberId(),
                        'position' => $party->getSignaturePosition(),
                        'page' => $part_sign->getSignaturePage(),
                        'mention' => __(
                            'components.contract.contract.application.views.contract'
                            .'.upload_signed_contract.signed_on_the_at'
                        ),
                        'reason' => "Signed by {$party->getSignatoryName()}",
                    ]);

                    $party->setYousignFileObjectId($fileObject->body->id);

                    App::make(ContractPartyRepository::class)->save($party);
                }
            }
        }

        // Step 6 : finish procedure
        $finished = $client->finishProcedure($procedure->body->id);

        if (in_array($finished->code, [200, 201, 204])) {
            $next_party_to_validate = App::make(ContractPartyRepository::class)
                ->getNextPartyThatShouldValidate($this->contract);

            if (isset($next_party_to_validate)) {
                $this->contract->setNextPartyToValidate($next_party_to_validate);
                $this->contractRepository->sendNotificationToValidateContractOnYousign(
                    $this->contract,
                    $next_party_to_validate,
                    false
                );
            } else {
                $first_signing_party = $this->contractPartyRepository->getFirstSigningParty($this->contract);
                $this->contract->setNextPartyToSign($first_signing_party);
                $this->contractRepository->sendNotificationToSignContract(
                    $this->contract,
                    $first_signing_party,
                    false
                );
            }

            $this->contract->setSentToSignatureAt(Carbon::now());
            $this->contractRepository->save($this->contract);
            App::make(ContractStateRepository::class)->updateContractState($this->contract);
        }

        return $finished;
    }
}
