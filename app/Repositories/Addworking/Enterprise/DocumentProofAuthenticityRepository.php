<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Repositories\BaseRepository;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Document;
use App\Http\Requests\Addworking\Enterprise\Document\StoreDocumentProofAuthenticityRequest;

class DocumentProofAuthenticityRepository extends BaseRepository
{
    public function createFromRequest(StoreDocumentProofAuthenticityRequest $request, Document $document)
    {
        $file   = File::from($request->file('proof_authenticity_file'))->saveAndGet();

        $document->setProofAuthenticity($file);
        $document->save();

        return $document;
    }

    public function updateFromRequest(StoreDocumentProofAuthenticityRequest $request, Document $document)
    {
        $old_file = $document->getProofAuthenticity();

        $old_file->delete();

        return $this->createFromRequest($request, $document);
    }
}
