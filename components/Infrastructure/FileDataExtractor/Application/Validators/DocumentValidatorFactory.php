<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Validators;

use Components\Infrastructure\FileDataExtractor\Domain\Exceptions\UnableToMakeValidator;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDetectorInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorFactoryInterface;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentValidatorInterface;
use Illuminate\Contracts\Container\Container;

class DocumentValidatorFactory implements DocumentValidatorFactoryInterface
{
    protected $container;
    protected $registry = [];

    public function __construct(Container $container, array $classes = [])
    {
        $this->container = $container;

        if ($classes) {
            foreach ($classes as $detector => $validator) {
                $this->register($detector, $validator);
            }
        }
    }

    public function register(string $detector, string $validator)
    {
        if (! class_exists($detector)) {
            throw new \InvalidArgumentException("no such class '{$detector}'");
        }

        if (! class_exists($validator)) {
            throw new \InvalidArgumentException("no such class '{$validator}'");
        }

        if (! in_array(DocumentDetectorInterface::class, class_implements($detector))) {
            throw new \InvalidArgumentException(
                "detector class should implement " . DocumentDetectorInterface::class
            );
        }

        if (! in_array(DocumentValidatorInterface::class, class_implements($validator))) {
            throw new \InvalidArgumentException(
                "extractor class should implement " . DocumentValidatorInterface::class
            );
        }

        $this->registry[$detector] = $validator;
    }

    public function makeFromDetector(DocumentDetectorInterface $detector): DocumentValidatorInterface
    {
        $detectorClass = get_class($detector);

        if (! isset($this->registry[$detectorClass])) {
            throw new UnableToMakeValidator($this, "no corresponding extractor found for '{$detectorClass}'");
        }

        $validatorClass = $this->registry[$detectorClass];

        try {
            return $this->container->make($validatorClass);
        } catch (\Exception $e) {
            throw new UnableToMakeValidator($this, "unable to instanciate '{$validatorClass}'", $e);
        }
    }
}
