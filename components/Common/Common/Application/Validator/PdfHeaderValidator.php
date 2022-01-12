<?php

namespace Components\Common\Common\Application\Validator;

use Components\Common\Common\Domain\Interfaces\FileHeaderValidatorInterface;

class PdfHeaderValidator implements FileHeaderValidatorInterface
{
    public static function validate($file_content): bool
    {
        return (bool)preg_match("/^%PDF-/", $file_content);
    }
}
