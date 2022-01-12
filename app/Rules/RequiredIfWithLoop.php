<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequiredIfWithLoop implements Rule
{
    protected $arr;
    protected $condition;

    public function __construct($arr, $condition)
    {
        $this->arr = $arr;
        $this->condition = $condition;
    }

    public function passes($attribute, $value)
    {
        if (is_null($this->arr)) {
            return true;
        }

        $required = in_array($this->condition, $this->arr);

        if ($required && is_null($value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Le champ :attribute est obligatoire !';
    }
}
