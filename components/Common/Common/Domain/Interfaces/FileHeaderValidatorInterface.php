<?php

namespace Components\Common\Common\Domain\Interfaces;

interface FileHeaderValidatorInterface
{
    public static function validate($file_content): bool;
}
