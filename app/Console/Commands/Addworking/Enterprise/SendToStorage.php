<?php

namespace App\Console\Commands\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use Exception;
use Generator;
use Illuminate\Console\Command;
use RuntimeException;

class SendToStorage extends Command
{
    protected $signature = 'document:send-to-storage {document?} {--disk}';

    protected $description = 'Sends to the documents to storage';

    public function handle()
    {
        $errors = [];

        $bar = $this->output->createProgressBar($this->getDocumentsCount());
        $bar->start();

        foreach ($this->getDocuments() as $document) {
            try {
                if (! $document->sendToStorage($this->option('disk') ?: null)) {
                    throw new RuntimeException("Unable to send document");
                }
            } catch (Exception $e) {
                $errors[] = [$document->id, $e->getMessage()];
            }

            gc_collect_cycles();
            $bar->advance();
        }

        $bar->finish();

        if (! empty($errors)) {
            $this->line(sprintf("\n\n%d errors encountered", count($errors)));
            $this->table(['Document UUID', 'Error'], $errors);
        }
    }

    protected function getDocuments(): Generator
    {
        if ($this->argument('document')) {
            yield Document::findOrFail($this->argument('document'));
            return;
        }

        yield from Document::withTrashed()->cursor();
    }

    protected function getDocumentsCount(): int
    {
        return $this->argument('document') ? 1 : Document::withTrashed()->count();
    }
}
