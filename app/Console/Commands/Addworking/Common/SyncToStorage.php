<?php

namespace App\Console\Commands\Addworking\Common;

use App\Models\Addworking\Common\File;
use Exception;
use Illuminate\Console\Command;
use Generator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SyncToStorage extends Command
{
    protected $signature = 'file:sync-to-storage {file?} {--disk=files_s3}';

    protected $description = 'Sync the db stored files to storage';


    public function handle()
    {
        if (! Config::get('files.storage.enabled', false)) {
            $this->error("Syncing files to storage is disabled");
            return;
        }

        $errors = $this->syncWithProgressBar();

        if (! empty($errors)) {
            $this->line(sprintf("\n\n%d errors encountered", count($errors)));
            $this->table(['File UUID', 'Error'], $errors);
        }
    }

    protected function syncWithProgressBar(): array
    {
        $errors = [];

        $bar = $this->output->createProgressBar($this->getFilesCount());
        $bar->start();

        foreach ($this->getFiles() as $file) {
            try {
                if (! $this->sync($file, $this->option('disk') ?: null)) {
                    throw new RuntimeException("Unable to sync file");
                }
            } catch (Exception $e) {
                $errors[] = [$file->id, $e->getMessage()];
            }

            gc_collect_cycles();
            $bar->advance();
        }

        $bar->finish();

        return $errors;
    }

    protected function getFiles(): Generator
    {
        if ($this->argument('file')) {
            yield File::withTrashed()->findOrFail($this->argument('file'));
            return;
        }

        yield from File::withTrashed()->cursor();
    }

    protected function getFilesCount(): int
    {
        return $this->argument('file') ? 1 : File::withTrashed()->count();
    }

    protected function sync(File $file, $disk = null): bool
    {
        $disk = $disk ?? Config::get('files.storage.disk');

        if (! Storage::disk($disk)->exists($file->id)) {
            $sent = Storage::disk($disk)->put($file->id, $file->content);
            if (! $sent) {
                $this->error("Error while sending file to S3 {$disk}");
            }

            return $sent;
        } else {
            $this->warn("The file is already present in {$disk}");
        }

        return true;
    }
}
