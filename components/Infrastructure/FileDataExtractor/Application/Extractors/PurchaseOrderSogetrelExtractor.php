<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\PurchaseOrderSogetrelData;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;

class PurchaseOrderSogetrelExtractor extends DocumentDataExtractor
{
    private $is_pdf_image = false;

    public function extract(\SplFileInfo $file): DocumentDataInterface
    {
        $contents = $this->getTextExtractor()->getContents($file);
        if (substr_count($contents, "\n") <= 3) {
            $this->is_pdf_image = true;
            $contents = $this->getTextExtractor()->getContents($file, $this->is_pdf_image);
        }

        return new PurchaseOrderSogetrelData($this, [
            'docusign_envelope_id'  => $this->extractDocusignEnvelopeId($contents),
            'command_number'        => $this->extractCommandNumber($contents),
            'workfield_identifier'  => $this->extractWorkfieldIdentifier($contents),
            'total_eur_ht'          => (float)$this->extractTotalEurHt($contents),
            'total_eur_tva'         => (float)$this->extractBaseTva($contents),
            'total_eur_ttc'         => (float)$this->extractTotalEuroTTC($contents),
            'is_autoliquidee'       => $this->extractIsAutoliquidee($contents),
            'reference'             => $this->extractReference($contents),
            'prestataire_oracle_id' => $this->extractOracleId($contents),
        ]);
    }

    protected function extractDocusignEnvelopeId(string $contents): ?string
    {
        return $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'DocuSign Envelope ID:');
    }

    protected function extractCommandNumber(string $contents): ?string
    {
        return $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Bon de commande numéro');
    }

    protected function extractWorkfieldIdentifier(string $contents): ?string
    {
        return $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Chantier');
    }

    protected function extractTotalEurHt(string $contents): ?string
    {
        if (!$this->is_pdf_image) {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Total EUR HT\n');
            return str_replace(',', '', $data);
        } else {
            $data = $this
                ->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'Total EUR HT');
            $data = str_replace(',', '', $data);
            return $data;
        }

        return null;
    }

    protected function extractBaseTva(string $contents): ?string
    {
        if (!$this->is_pdf_image) {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Base TVA ');
            if ($data) {
                $data = trim(preg_replace('/[0-9]*%/', '', $data));
                $data = str_replace(',', '', $data);
            }
            return $data;
        } else {
            $regex = '/Base TVA [0-9]*%\s[" .*"]*.*\s/';
            if (preg_match($regex, $contents, $matches)) {
                $data = trim(preg_replace('/Base TVA [0-9]*%/', '', $matches[0]));
                return str_replace(',', '', $data);
            }
        }

        return null;
    }

    protected function extractTotalEuroTTC(string $contents): ?string
    {
        if (!$this->is_pdf_image) {
            $data = $this->dataExtractorHelper->extractDataOfLinesStartingWith($contents, 'Total EUR TTC\n');
            return str_replace(',', '', $data);
        } else {
            $data = $this
                ->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'Total EUR TTC');
            $data = str_replace(',', '', $data);
            return $data;
        }

        return null;
    }

    protected function extractIsAutoliquidee(string $contents): ?bool
    {
        return $this->dataExtractorHelper->extractDataContains($contents, 'Autoliquidée');
    }

    protected function extractReference(string $contents): ?string
    {
        $regex = "/Réf: .*\s/";
        if (preg_match($regex, $contents, $matches)) {
            $data = preg_replace('/[\n\r]/', '', $matches[0]);
            return trim(preg_replace('/Réf:[ ]*/', '', $data));
        }
        return null;
    }

    protected function extractOracleId(string $contents): ?string
    {
        $adress = $this
            ->dataExtractorHelper
            ->extractDataFromLinesFollowingLineStartingWith($contents, 'Adresse de facturation\r\n');
        $words = explode(' ', $adress);
        $data = array_pop($words);
        if (is_null($data) || $data === '') {
            $data = $this->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, 'Adresse de facturation');
            $data = $this->dataExtractorHelper
                ->extractDataFromLinesFollowingLineStartingWith($contents, $data);
        }
        return $data;
    }
}
