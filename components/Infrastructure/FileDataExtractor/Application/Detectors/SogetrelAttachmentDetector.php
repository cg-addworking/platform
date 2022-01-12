<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Detectors;

use Components\Infrastructure\FileDataExtractor\Application\Detectors\DocumentDetector;
use Illuminate\Support\Str;

class SogetrelAttachmentDetector extends DocumentDetector
{
    protected const MENTIONS = [
        "ATTACHEMENT Exemplaire à",
        "TOTAL EUR HT",
        "Situation d'Avancement",
        "SOGETREL",
    ];

    protected const SCORE_THRESHOLD = 0.8;

    public function detect(\SplFileInfo $file, float &$score = -1): bool
    {
        $contents = $this->getTextExtractor()->getContents($file);
        if (substr_count($contents, "\n") <= 10) {
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
