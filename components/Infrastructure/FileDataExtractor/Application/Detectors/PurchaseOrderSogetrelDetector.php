<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Detectors;

use Components\Infrastructure\FileDataExtractor\Application\Detectors\DocumentDetector;
use Illuminate\Support\Str;

class PurchaseOrderSogetrelDetector extends DocumentDetector
{
    protected const MENTIONS = [
        "Bon de commande numéro",
        "NUMÉRO À RAPPELER SUR VOTRE FACTURE",
        "Total EUR HT",
        "Adresse de facturation",
        "Adresse de livraison",
        "SOGETREL",
    ];

    protected const SCORE_THRESHOLD = 0.8;

    public function detect(\SplFileInfo $file, float &$score = -1): bool
    {
        $contents = $this->getTextExtractor()->getContents($file);
        if (substr_count($contents, "\n") <= 3) {
            $contents = $this->getTextExtractor()->getContents($file, true);
        }

        $matches = 0;
        foreach (self::MENTIONS as $mention) {
            if (Str::contains($contents, $mention)) {
                $matches++;
            }
        }

        $score = $matches / count(self::MENTIONS);
        return $score > self::SCORE_THRESHOLD;
    }
}
