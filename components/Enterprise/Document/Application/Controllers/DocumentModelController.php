<?php

namespace Components\Enterprise\Document\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Enterprise\Document\Application\Jobs\SendDocumentToSign;
use Components\Enterprise\Document\Application\Models\Document;
use App\Models\Addworking\Enterprise\DocumentType as DocumentTypeInApp;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Application\Notifications\RefusedDocumentNotification;
use Components\Enterprise\Document\Application\Repositories\DocumentRepository;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\GenerateDocument;
use Components\Infrastructure\ElectronicSignature\Application\Yousign\Client as Yousign;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DocumentModelController extends Controller
{
    public function show(Enterprise $enterprise, Document $document)
    {
        $this->authorize('sign', $document);

        return view(
            'document::document_model.show',
            compact('document', 'enterprise')
        );
    }

    public function sign(Enterprise $enterprise, Document $document)
    {
        $this->authorize('sign', $document);

        $enterprise_language = $enterprise->getContractualizationLanguage() ?? 'fr';

        try {
            $signatory = Auth::user();

            $document->setSignedBy($signatory);
            $document->setSignatoryName($signatory->name);
            App::make(DocumentRepository::class)->save($document);

            SendDocumentToSign::dispatchSync($document, $signatory, $enterprise_language);
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }

        $document->refresh();

        $client = new Yousign;

        $sign_frame_ui = $client->getSignIframeUri($document->getYousignMemberId(), $enterprise_language);

        return view(
            'document::document_model.sign',
            compact('document', 'sign_frame_ui', 'enterprise')
        );
    }

    /**
     * Webhook called by yousign when a procedure of signature is refused
     *
     * @param Request $request
     */
    public function callbackProcedureRefused(Request $request)
    {
        if ($request->header('X-Custom-Header') != "941cd088-2f6d-41f7-9dee-eb84a9964d54") {
            abort(401);
        }

        try {
            $data = $request->all();
            $document = App::make(DocumentRepository::class)
                ->findByYousignProcedureId("/procedures/".$data['procedure']['id']);

            $content = $data['member']['comment'];
            if (!is_null($content)) {
                $author = $document->getSignedBy();
                $visibility = Comment::VISIBILITY_PUBLIC;
                $comment = new Comment(@compact('content', 'visibility'));
                $comment->commentable()->associate($document);
                $comment->author()->associate($author);
                $comment->save();

                Notification::route('mail', 'confo+refusattest@addworking.com')
                    ->notify(new RefusedDocumentNotification($document, $comment));
            }

            $document->setStatus(DocumentEntityInterface::STATUS_REFUSED_SIGNATURE);
            App::make(DocumentRepository::class)->save($document);
            $document->delete();
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Webhook called by yousign when a procedure of signature is finished
     *
     * @param Request $request
     * @throws GuzzleException
     */
    public function callbackProcedureFinished(Request $request)
    {
        if ($request->header('X-Custom-Header') != "941cd088-4f6d-41f7-9dee-eb84a9964d52") {
            abort(401);
        }

        try {
            $data = $request->all();
            $document_repository = App::make(DocumentRepository::class);
            $document = $document_repository->findByYousignProcedureId("/procedures/".$data['procedure']['id']);
            /* @var Document $document */

            $document->setStatus(DocumentEntityInterface::STATUS_PENDING);
            $document->setIsPreCheck(true);
            $document->setSignedAt(Carbon::parse($data['procedure']['updatedAt'])->format('Y-m-d H:i:s'));
            $document_repository->save($document);

            $client = new Yousign;
            $content = $client->downloadFile($document->getYousignFileId());
            $file = $document_repository->createFile(base64_decode($content->body));
            $document->files()->detach();
            $document->refresh();
            $document->setFiles($file);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function addRequiredDocument(Enterprise $enterprise, Document $document)
    {
        $this->authorize('addRequiredDocument', $document);

        return view(
            'document::document_model.add_required_document',
            compact('enterprise', 'document')
        );
    }

    public function storeRequiredDocument(Request $request, Enterprise $enterprise, Document $document)
    {
        $this->authorize('addRequiredDocument', $document);

        $request->validate([
            'file' => 'required|file|mimes:pdf,csv,txt|max:4000|min:1',
        ]);

        App::make(DocumentRepository::class)->saveFile($document, $request->file('file'));

        return redirect(route('addworking.enterprise.document.show', [$enterprise, $document]));
    }
}
