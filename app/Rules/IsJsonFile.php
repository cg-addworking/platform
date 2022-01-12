<?php

namespace App\Rules;

use Components\Common\Common\Application\Validator\PdfHeaderValidator;
use Illuminate\Contracts\Validation\Rule;

class IsJsonFile implements Rule
{
    public function passes($attribute, $values)
    {
        if (!is_array($values)) {
            return false;
        }

        foreach ($values as $v) {
            $d = json_decode($v, true);
            if (!isset($d['name'], $d['type'], $d['size'], $d['data'], $d['id'])) {
                return false;
            }
            if ($d['size'] > 5000000) {
                return false;
            }
            if ($d['type'] != 'application/pdf') {
                return false;
            }
            if (!PdfHeaderValidator::validate(base64_decode($d['data']))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le fichier n\'est pas au format PDF ou dépasse la taille maximale autorisée (4Mo)';
    }
}
