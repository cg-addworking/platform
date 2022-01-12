<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Detectors;

use Components\Infrastructure\FileDataExtractor\Application\Detectors\DocumentDetector;
use Illuminate\Support\Str;

class KbisDetector extends DocumentDetector
{
    protected const MENTIONS = [
        "Greffe du Tribunal de Commerce de",
        "Extrait Kbis",
        "EXTRAIT D'IMMATRICULATION PRINCIPALE AU REGISTRE DU COMMERCE ET DES SOCIETES",
        "IDENTIFICATION DE LA PERSONNE MORALE",
        "GESTION, DIRECTION, ADMINISTRATION, CONTROLE, ASSOCIES OU MEMBRES",
        "RENSEIGNEMENTS RELATIFS A L'ACTIVITE ET A L'ETABLISSEMENT PRINCIPAL",
        "Le Greffier",
        "FIN DE L'EXTRAIT"
    ];

    protected const SCORE_THRESHOLD = 0.8;

    public function detect(\SplFileInfo $file, float &$score = -1): bool
    {
        $contents = $this->getTextExtractor()->getContents($file);

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
