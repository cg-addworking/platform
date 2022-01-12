<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasAJob implements Rule
{
    protected $arr;

    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    public function passes($attribute, $value)
    {
        if ($this->arr['electrician'] == 0
            && $this->arr['multi_activities'] == 0
            && $this->arr['technicien_cavi'] == 0
            && $this->arr['engineering_office'] == 0
            && $this->arr['civil_engineering'] == 0) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'Vous devez répondre "Oui" à au moins une des questions suivantes:
        Êtes-vous électricien ?
        Êtes-vous Technicien Télécom ?
        Êtes-vous Technicien CAVI ?
        Travaillez-vous en Bureau d\'études ?
        Travaillez-vous dans le Génie Civil ?';
    }
}
