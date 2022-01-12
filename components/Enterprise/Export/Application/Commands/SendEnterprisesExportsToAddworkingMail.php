<?php

namespace Components\Enterprise\Export\Application\Commands;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\Export\Application\Builders\EnterpriseCsvBuilder;
use Components\Enterprise\Export\Application\Builders\PartnershipCsvBuilder;
use Components\Enterprise\Export\Application\Builders\UserCsvBuilder;
use Components\Enterprise\Export\Application\Mails\EnterpriseCsvExportMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEnterprisesExportsToAddworkingMail extends Command
{
    protected $signature = "enterprise:send-enterprises-exports {email=charles@addworking.com}";
    protected $description = 'Send to Addworking the three enterprises csv exports in a zip file';

    protected $path;
    protected $zip;

    public function handle()
    {
        if (! function_exists('exec')) {
            throw new \RuntimeException("the 'exec' function is mandatory for this command");
        }

        $email = $this->argument('email');

        $this->zip()->send($email);
    }

    protected function zip()
    {
        $this->path = sys_get_temp_dir()."/export";

        if (! is_dir($this->path) && ! mkdir($this->path, 0700, true)) {
            throw new \Exception("Unable to create directory : {$this->path}", 1);
        }

        $enterprises = $this->exportEnterprises();
        $users = $this->exportUsers();
        $partnerships = $this->exportPartnerships();

        $this->zip = $this->path."/export.zip";
        $zip_arg = escapeshellarg($this->zip);
        $file_arg_enterprises = escapeshellarg($enterprises->getPathName());
        $file_arg_users = escapeshellarg($users->getPathName());
        $file_arg_partnerships = escapeshellarg($partnerships->getPathName());

        // -r stands for recursive
        // -j stands for junk (forget about paths in Zip archive)
        exec(
            $cmd = "zip -j -r {$zip_arg} {$file_arg_enterprises} {$file_arg_users} {$file_arg_partnerships}",
            $output,
            $return_var
        );

        if ($return_var != "0") {
            throw new \RuntimeException("unable to run command '{$cmd}':".implode('\n', $output));
        }

        $this->info('Zip action finished successfully');

        return $this;
    }

    private function exportEnterprises(): \SplFileObject
    {
        $query = Enterprise::query();
        $this->info("Generating enterprises csv export...");
        $bar = $this->output->createProgressBar($query->count());
        $bar->start();
        $csv = (new EnterpriseCsvBuilder($this->path.'/'.date('Ymd').'-enterprises.csv'))
            ->addAll($query->cursor(), fn() => $bar->advance());
        $bar->finish();
        return $csv;
    }

    private function exportUsers(): \SplFileObject
    {
        $query = User::has('enterprises');
        $this->info("Generating users csv export...");
        $bar = $this->output->createProgressBar($query->count());
        $bar->start();
        $csv = (new UserCsvBuilder(($this->path.'/'.date('Ymd').'-users.csv')))
            ->addAll($query->cursor(), fn() => $bar->advance());
        $bar->finish();
        return $csv;
    }

    private function exportPartnerships(): \SplFileObject
    {
        $query = Enterprise::has('customers');
        $this->info("Generating partnerships csv export...");
        $bar = $this->output->createProgressBar($query->count());
        $bar->start();
        $csv = (new PartnershipCsvBuilder(($this->path.'/'.date('Ymd').'-partnerships.csv')))
            ->addAll($query->cursor(), fn() => $bar->advance());
        $bar->finish();
        return $csv;
    }

    private function send(string $email)
    {
        Mail::to($email)->send(new EnterpriseCsvExportMail($this->zip));

        $this->info('Mail sent');
    }
}
