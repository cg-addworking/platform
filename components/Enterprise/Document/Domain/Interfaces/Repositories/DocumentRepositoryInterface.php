<?php
namespace Components\Enterprise\Document\Domain\Interfaces\Repositories;

use App\Models\Addworking\Common\File;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentEntityInterface;

interface DocumentRepositoryInterface
{
    public function make(): DocumentEntityInterface;
    public function save(Document $document): ?DocumentEntityInterface;
    public function findByYousignProcedureId(string $id): ?DocumentEntityInterface;
    public function createFile($content);
    public function saveFile(Document $document, $file);
    public function mergeDocumentPdf(Document $document): File;
}
