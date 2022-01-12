<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Jobs\Addworking\Contract\Contract\CreateBlankContractJob;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CreateCps2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $addworking;
    protected $addworkingEnterpriseRepository;
    protected $contract;
    protected $sogetrelEnterpriseRepository;
    protected $vendor;

    public function __construct(
        AddworkingEnterpriseRepository $addworking,
        SogetrelEnterpriseRepository $sogetrel
    ) {
        $this->addworkingEnterpriseRepository = $addworking;
        $this->sogetrelEnterpriseRepository = $sogetrel;
    }

    public function handle(Enterprise $vendor): Contract
    {
        $this->addworking = $this->addworkingEnterpriseRepository->getAddworkingEnterprise();
        $this->vendor     = $vendor;

        $this->createContract()
            ->createContractParties()
            ->createFile();

        return $this->contract;
    }

    protected function createContract(): self
    {
        $create_contract_job = new CreateBlankContractJob($this->addworking, [
            'name' => "CPS2 {$this->vendor->name}",
        ]);

        if (! $create_contract_job->handle()) {
            throw new \RuntimeException("unable to create contract: job failed");
        }

        $this->contract = $create_contract_job->contract;

        if (! $this->contract instanceof Contract) {
            throw new \RuntimeException("unable to create contract: invalid contract created");
        }

        if (! $this->contract->exists) {
            throw new \RuntimeException("unable to create contract: contract is not saved");
        }

        return $this;
    }

    protected function createContractParties(): self
    {
        $party_1 = $this->contract->contractParties()->make([
            'denomination' => "Le Prestataire",
            'order'        => 1,
        ]);

        $party_1->enterprise()->associate($this->vendor);

        if ($this->vendor->signatories()->exists()) {
            $party_1->user()->associate(
                $this->vendor->signatories()->first()
            );
        }

        $party_1->save();

        $party_2 = $this->contract->contractParties()->make([
            'denomination' => "AddWorking",
            'order'        => 2,
        ]);

        $party_2->enterprise()->associate($this->addworking);

        if ($this->addworking->signatories()->exists()) {
            $party_2->user()->associate(
                $this->addworking->signatories()->first()
            );
        }

        $party_2->save();

        return $this;
    }

    protected function createFile(): self
    {
        $pdf = PDF::loadView("{$this->getDomain()}.contract.contract.cps2", [
            'vendor' => $this->vendor,
        ]);

        $file = File::from([
            'path'      => uniqid(Str::snake($this->contract->name)) . '.pdf',
            'mime_type' => "application/pdf",
            'content'   => $pdf->output(),
        ]);

        if (! $file->save()) {
            throw new \RuntimeException("unable to create contract: file creation failed");
        }

        $this->contract
            ->file()->associate($file)
            ->save();

        return $this;
    }

    protected function getDomain(): string
    {
        if ($this->sogetrelEnterpriseRepository->isVendorOfSogetrel($this->vendor) ||
            $this->sogetrelEnterpriseRepository->isVendorOfSogetrelSubsidiaries($this->vendor)
        ) {
            return 'sogetrel';
        }

        return 'addworking';
    }
}
