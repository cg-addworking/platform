<?php

namespace App\Console\Commands\Addworking\Common;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SyncAwsWithScaleway extends Command
{
    protected $signature = 'file:sync-aws-with-scaleway {created_at?}';

    protected $description = 'Sync the files stored in AWS with Scaleway';

    public function handle()
    {
        if (! config('files.storage.sync-aws-scaleway')) {
            $this->error("Syncing files between AWS and Scaleway disabled");
            return;
        }

        if ($this->argument('created_at')) {
            $created_at = Carbon::createFromFormat('Y-m-d', $this->argument('created_at'))
                ->startOfDay()->toDateString();
        } else {
            $created_at = Carbon::today('Europe/Paris')->startOfDay()->subDay()->toDateString();
        }

        $this->info("Sync Date : {$created_at}");

        $query = 'SELECT "acf"."id" AS "id","acf"."created_at" AS "created_at"';
        $query .= ' FROM "public"."addworking_common_files" AS "acf"';
        $query .= ' WHERE ((("acf"."created_at") >= '."'".$created_at."'".')) ORDER BY "acf"."created_at" ASC';

        $files = DB::select(DB::raw("$query"));

        $scaleway_disk = "scaleway_s3";
        $aws_disk = "files_s3";

        if (empty($files)) {
            $this->info("Nothing to sync");
            return;
        }

        foreach ($files as $file) {
            if (Storage::disk($aws_disk)->missing($file->id)) {
                $this->error("File {$file->id} => {$file->created_at} missing in AWS Bucket");
                continue;
            }

            if (! Storage::disk($scaleway_disk)->exists($file->id)) {
                $file_content = Storage::disk($aws_disk)->get($file->id);

                $sent = Storage::disk($scaleway_disk)->put($file->id, $file_content);
                if (! $sent) {
                    $this->error("Error while sending file to Scaleway bucket");
                } else {
                    $this->info("OK, {$file->id} => {$file->created_at}");
                }
            } else {
                $this->warn("The file {$file->id} => {$file->created_at} is already present in Scaleway bucket");
            }
        }
    }
}
