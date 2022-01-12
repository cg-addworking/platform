<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\AttachementSogetrelData;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;

class AttachementSogetrelExtractor extends DocumentDataExtractor
{
    private $is_pdf_image = false;

    public function extract(\SplFileInfo $file): DocumentDataInterface
    {
        $contents = $this->getTextExtractor()->getContents($file);
        if (substr_count($contents, "\n") <= 10) {
            $this->is_pdf_image = true;
            $contents = $this->getTextExtractor()->getContents($file, $this->is_pdf_image);
        }

        return new AttachementSogetrelData($this, [
            'docusign_envelope_id' => $this->extractDocusignEnvelopeId($contents),
            'contract_num'         => $this->extractContractNumber($contents),
            'attachement_num'      => (int)$this->extractAttachementNo($contents),
            'total_eur_ht'         => (float)$this->extractTotalEurHt($contents),
            'total_eur_ttc'        => (float)$this->extractTotalEurTtc($contents),
            'total_eur_tva'        => (float)$this->extractTva($contents),
        ]);
    }

    protected function extractDocusignEnvelopeId(string $contents): ?string
    {
        return $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'DocuSign Envelope ID:');
    }

    protected function extractAttachementNo(string $contents): ?string
    {
        if ($this->is_pdf_image) {
            $data = $this
                ->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'Attachement No.');
        } else {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Attachement No.');
        }

        return $data;
    }

    protected function extractContractNumber(string $contents): ?string
    {
        $regex = '/Contrat No.\s[" .*"]* [0-9A-Z]*/';
        if (!$this->is_pdf_image) {
            if (preg_match($regex, $contents, $matches)) {
                $data = preg_replace('/[\n\r]/', '', $matches[0]);
                return preg_replace('/Contrat No.[ ]*/', '', $data);
            }
        } else {
            $regex = '/Contrat No.\s[A-Z0-9]*\s/';
            if (preg_match($regex, $contents, $matches)) {
                $data = preg_replace('/[\n\r]/', '', $matches[0]);
                return str_replace('Contrat No.', '', $data);
            }
        }

        return null;
    }

    protected function extractTotalEurHt(string $contents): ?string
    {
        if ($this->is_pdf_image) {
            $data = $this
                ->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'TOTAL EUR HT');
        } else {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'TOTAL EUR HT');
        }
        $data = preg_replace('/[\s]/', '', $data);
        $data = str_replace(',', '.', $data);
        return $data;
    }

    protected function extractTotalEurTtc(string $contents): ?string
    {
        if ($this->is_pdf_image) {
            $data = $this
                ->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'TOTAL EUR TTC');
        } else {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'TOTAL EUR TTC');
        }
        $data = preg_replace('/[\s]/', '', $data);
        $data = str_replace(',', '.', $data);
        return $data;
    }

    protected function extractTva(string $contents): ?string
    {
        if ($this->is_pdf_image) {
            $data = $this->dataExtractorHelper->extractDataFromLinesFollowingLineStartingWith($contents, 'TVA');
        } else {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'TVA');
        }
        $data = preg_replace('/[\s]/', '', $data);
        $data = str_replace(',', '.', $data);
        return $data;
    }
}
