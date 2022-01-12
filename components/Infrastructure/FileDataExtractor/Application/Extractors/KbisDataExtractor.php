<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\KbisDocumentData;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;

class KbisDataExtractor extends DocumentDataExtractor
{
    public function extract(\SplFileInfo $file): DocumentDataInterface
    {
        $contents = $this->getTextExtractor()->getContents($file);

        return new KbisDocumentData($this, [
            'siret_number' => $this->extractSiretNumber($contents),
            'company_name' => $this->extractCompanyName($contents),
            'date' => $this->extractDate($contents),
            'verification_key' => $this->extractVerificationKey($contents),
        ]);
    }

    protected function extractSiretNumber(string $contents): ?string
    {
        // on low-res pics, 'numéro' is sometimes interpreted as 'muméro'
        // by the OCR
        $regex = "/Immatriculation au RCS, [nm]uméro\s+([0-9]{3}\s+[0-9]{3}\s+[0-9]{3})\s+R\.C\.S\./";

        if (preg_match($regex, $contents, $matches)) {
            return preg_replace('/\s+/', '', $matches[1]);
        }

        return null;
    }

    protected function extractCompanyName(string $contents): ?string
    {
        // - on low-res pics, 'sociale' is sometimes interpreted as 'sociule'
        // by the OCR
        $regex = "/Dénomination ou raison soci[au]le\s+(.*)\n/";
        $except = ["Forme juridique", "Capital social"];

        if (preg_match($regex, $contents, $matches) && !in_array(trim($matches[1]), $except)) {
            return trim($matches[1]);
        }

        return null;
    }

    protected function extractDate(string $contents): ?\DateTime
    {
        $regex = "/Date d'immatriculation\s+([0-9]{2})\/([0-9]{2})\/([0-9]{4})/";

        if (preg_match($regex, $contents, $matches)) {
            return new \DateTime("{$matches[3]}-{$matches[2]}-{$matches[1]}");
        }

        return null;
    }

    protected function extractVerificationKey(string $contents): ?string
    {
        $regex = "/Code de vérification :\s+(\S+)/";

        if (preg_match($regex, $contents, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
