<?php

namespace Components\Contract\Model\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Domain\Exceptions\ContractModelPartCreationFailedException;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Illuminate\Support\Facades\App;
use Components\Infrastructure\PdfManager\Application\PdfManager;

class ContractModelPartRepository implements ContractModelPartRepositoryInterface
{
    public function make($data = []): ContractModelPart
    {
        return new ContractModelPart($data);
    }

    public function save(ContractModelPartEntityInterface $contract_model_part)
    {
        try {
            $contract_model_part->save();
        } catch (ContractModelPartCreationFailedException $exception) {
            throw $exception;
        }

        $contract_model_part->refresh();

        return $contract_model_part;
    }

    public function list(ContractModelEntityInterface $contract_model, ?array $filter = null, ?string $search = null)
    {
        return ContractModelPart::query()
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })->orderBy('order')->paginate(25);
    }

    public function createFile($content, bool $html = false)
    {
        if ($html) {
            return File::from($content)
                ->fill(['mime_type' => "text/html"])
                ->name("/". uniqid() ."-%ts%.html")
                ->saveAndGet();
        }

        return File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/". uniqid() ."-%ts%.pdf")
            ->saveAndGet();
    }

    public function findByNumber(int $number): ?ContractModelPartEntityInterface
    {
        return ContractModelPart::where('number', $number)->first();
    }

    public function delete(ContractModelPartEntityInterface $contract_model_part): bool
    {
        foreach ($contract_model_part->getVariables() as $variable) {
            if ($variable->getContractModelPart()->count() === 1) {
                App::make(ContractModelVariableRepositoryInterface::class)->deleteVariable($variable);
            }
        }
        return $contract_model_part->delete();
    }

    public function findByOrder(
        ContractModelEntityInterface $contract_model,
        int $order
    ): ?ContractModelPartEntityInterface {
        return ContractModelPart::where('order', $order)
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })->first();
    }

    public function findByContractModelWithFiles(ContractModelEntityInterface $contract_model)
    {
        return ContractModelPart::query()
            ->with(['file', 'contractModel'])
            ->whereHas('contractModel', function ($query) use ($contract_model) {
                $query->where('id', $contract_model->getId());
            })
            ->get();
    }

    public function generate(ContractModelPartEntityInterface $contract_model_part)
    {
        $pdf = App::make(PdfManager::class)->htmlToPdf(
            $contract_model_part->getFile()->content,
            "{$contract_model_part->getDisplayName()} - {$contract_model_part->getContractModel()->getDisplayName()}"
        );

        return $pdf->download(uniqid('preview_').".pdf");
    }

    public function download(ContractModelPartEntityInterface $contract_model_part)
    {
        return $contract_model_part->getFile()->download();
    }

    public function createFileFromPdf(ContractModelPartEntityInterface $contract_model_part)
    {
        $html = $this->formatTextForPdf($contract_model_part->getText());

        $pdf  = App::make(PdfManager::class)->htmlToPdf($html)->stream()->content();

        $file = App::make(ContractModelPartRepository::class)->createFile($pdf);

        return $file;
    }

    public function formatTextForPdf(string $text): string
    {
        $text = \Normalizer::normalize($text);

        $html = '<html><head>';
        $html .= '<style> 
                    @page { margin: 2.5cm 1.5cm; } 
                    * { word-break: break-word; word-wrap: break-word; }
                    body { width: 100%; } 
                    footer { position: fixed; bottom: -60px; height: 50px; left: 0px; right: 0px;}
                    .page_break { page-break-before: always; }
                </style>';
        $html .= '</head>';
        $html .= '<footer></footer>';
        $html .= '<body>';
        $html .= $text;
        $html .= '</body>';
        $html .= '</html>';
        $html = str_replace('<!-- pagebreak -->', '<span class="page_break"></span>', $html);

        return $html;
    }
}
