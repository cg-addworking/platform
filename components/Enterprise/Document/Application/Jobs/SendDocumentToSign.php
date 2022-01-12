<?php

namespace Components\Enterprise\Document\Application\Jobs;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Application\Repositories\DocumentRepository;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SendDocumentToSign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;
    protected $signatory;

    /**
     * @var string
     */
    protected string $enterprise_language;

    public function __construct(Document $document, User $signatory, string $enterprise_language)
    {
        $this->document = $document;
        $this->signatory = $signatory;
        $this->enterprise_language = $enterprise_language;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! config('yousign.document_enabled')) {
            Log::warning("Yousign : you can't sign the document {$this->document->getId()}, the system is disabled");
            return;
        }

        $client = new Yousign;
        $procedure = $client->startProcedure([
            'name' => str_replace(',', '', $this->document->getDocumentType()->getDisplayName()),
            'start' => false,
            'archive' => false,
            'ordered' => true,
            'initials' => config('yousign.initials_enabled'),
            'config' => [
                'webhook' => [
                    'procedure.refused' => [
                        [
                            'url' =>
                                (env('YOUSIGN_WEBHOOK_IN_LOCAL') ?? env('APP_URL'))
                                . "/document/callback/procedure-refused",
                            'method' => "GET",
                            'headers' => ['X-Custom-Header' => '941cd088-2f6d-41f7-9dee-eb84a9964d54']
                        ]
                    ],
                    'procedure.finished' => [
                        [
                            'url' =>
                                (env('YOUSIGN_WEBHOOK_IN_LOCAL') ?? env('APP_URL'))
                                . "/document/callback/procedure-finished",
                            'method' => "GET",
                            'headers' => ['X-Custom-Header' => '941cd088-4f6d-41f7-9dee-eb84a9964d52']
                        ]
                    ]
                ]
            ]
        ]);

        $this->document->setYousignProcedureId($procedure->body->id);
        App::make(DocumentRepository::class)->save($this->document);

        if ($this->enterprise_language != 'de') {
            $subject_security_code = 'Signature électronique: Code de sécurité';
            $content_security_code = 'Votre code de sécurité pour signer vos documents est le : {{code}}';
        } else {
            $subject_security_code = 'Digitale Unterschrift: Sicherheitskode';
            $content_security_code = 'Ihrer Sicherheitskode, um Ihre Dokumente zu unterzeichnen, ist : {{code}}';
        }

        $member = $client->addMember([
            'position' => 1,
            'firstname' => str_replace(',', '', $this->signatory->firstname),
            'lastname' => str_replace(',', '', $this->signatory->lastname),
            'email' => (null !== env('YOUSIGN_TEST_EMAIL_ROOT'))
                ? env('YOUSIGN_TEST_EMAIL_ROOT') . "+document@addworking.com"
                : $this->signatory->email,
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

        $this->document->setYousignMemberId($member->body->id);
        App::make(DocumentRepository::class)->save($this->document);

        // if the document model requires documents to be filed then the added document is merged with the document
        //model to send it to yousign otherwise we send only the document model.

        if ($this->document->getRequiredDocument()) {
            $file = App::make(DocumentRepository::class)->mergeDocumentPdf($this->document);
        } else {
            $file = $this->document->files()->first();
        }

        $file = $client->addFile([
            'name' => str_replace(',', '', $this->document->getDocumentTypeModel()->getDisplayName()),
            'position' => 1,
            'content' => base64_encode($file->content),
            'procedure' => $procedure->body->id,
            'type' => $client::FILE_SIGNABLE
        ]);

        $this->document->setYousignFileId($file->body->id);
        App::make(DocumentRepository::class)->save($this->document);

        $client->addSignature([
            'file' => $file->body->id,
            'member' => $member->body->id,
            'position' => '432,70,560,141',
            'page' => $this->document->getDocumentTypeModel()->getSignaturePage(),
            'mention' => 'Signé par {firstname} {lastname} le {date.fr}',
        ]);

        $client->finishProcedure($procedure->body->id);
    }
}
