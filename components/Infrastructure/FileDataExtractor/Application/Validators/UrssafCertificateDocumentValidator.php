<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use App\Models\Addworking\Enterprise\Document;
use Components\Connector\Mindee\Application\Data\ExtraitKbisData;
use Components\Connector\Mindee\Application\Data\RegularisationFiscaleMicroData;
use Components\Connector\Mindee\Application\Data\UrssafMicroData;
use Components\Connector\Mindee\Application\Data\UrssafSocieteData;
use Components\Connector\Mindee\Domain\Interfaces\ComplianceDocumentDataInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\WrongDocumentDataPassedToValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidationResponseInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UrssafCertificateDocumentValidator implements DocumentValidatorInterface
{
    public function checkProofOfAuthenticity(string $key_code): DocumentValidationResponseInterface
    {
        if (! $key_code) {
            return new DocumentValidationResponse(false);
        }

        $process = new Process(
            ['phantomjs', __DIR__ . '/Urssaf.js', $key_code]
        );

        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        if (is_null($data = json_decode($output, true))) {
            throw new \RuntimeException("unable to parse JSON output '{$output}'");
        }

        return new UrssafCertificateDocumentValidationResponse(true, $data);
    }

    /**
     * @param ExtraitKbisData $data
     * @param Document $document
     * @param bool $prevalidation
     * @return bool
     * @throws WrongDocumentDataPassedToValidator
     */
    public function specificValidation(
        ComplianceDocumentDataInterface $data,
        Document $document,
        bool $prevalidation
    ): bool {
        if (!$data instanceof UrssafSocieteData &&
            !$data instanceof UrssafMicroData
        ) {
            throw new WrongDocumentDataPassedToValidator();
        }
        return $prevalidation;
    }
}
