<?php

namespace App\Domain\Sogetrel;

use App\Models\Addworking\Common\Department;
use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;

class PassworkCsvBuilder extends CsvBuilder
{
    /**
     * Headers
     *
     * var array
     */
    protected $headers = [
        0  => "Date de Création",
        1  => "Statut",
        2  => "Contacté",
        3  => "So'connext",
        4  => "Nom Prénom",
        5  => "Téléphone",
        6  => "Email",
        7  => "Entreprise",
        8  => "URL",
        9  => "Nombre de salariés",
        10 => "Siret",
        11 => "Pose de compteurs GAZPAR",
        12 => "Pose de compteurs LINKY",
        13 => "Niveau",
        14 => "Réseau RTC: Monteur câbleur BL",
        15 => "Niveau",
        16 => "Réseau RTC: Technicien raccordeur abonnés LT",
        17 => "Niveau",
        18 => "Réseau fibre optique: Monteur câbleur transport / D1",
        19 => "Niveau",
        20 => "Réseau fibre optique: Monteur câbleur D2",
        21 => "Niveau",
        22 => "Réseau fibre optique : Technicien raccordeur D1/D2",
        23 => "Niveau",
        24 => "Réseau fibre optique: Technicien raccordeur abonnés D3",
        25 => "Niveau",
        26 => "Réseau fibre optique : Soudeur optique",
        27 => "Niveau",
        28 => "Réseau télécom entreprise: Technicien intervention CPE",
        29 => "Niveau",
        30 => "Radio : Monteur cableur radio",
        31 => "Niveau",
        32 => "Habilitations",
        33 => "Chargé d'études BE",
        34 => "Dessinateur projeteur",
        35 => "Piqueteur télécom",
        36 => "Titres / qualifications",
        37 => "Commentaire",
        38 => "Bureau d’études",
        39 => "Création et maintenance de réseau VRD (Voirie et Réseau Divers : Télécom, secs, humides)",
        40 => "Réalisation et reprises de réfection (provisoires ou définitifs)",
        41 => "Plantation de poteaux avec tarière (neuf ou remplacement)",
        42 => "Plantation de poteaux à la main (neuf ou de remplacement)",
        43 => "Pose d’armoires de rue (création d’adductions ; dalles de propreté)",
        44 => "Pose de chambre Télécom",
        45 => "Réseaux sans tranchées (forage dirigé horizontal ; fonçage)",
        46 => "Gestion des procédures (DT, DICT, Permissions de voirie…)",
        47 => "Code postal du siege",
        48 => "comment nous avez-vous connu ?",
    ];

    protected $departments;

    public function __construct(
        string $path = null,
        string $separator = ";",
        string $enclosure = "\"",
        string $escape = "\\"
    ) {
        $this->departments = Department::orderBy('insee_code')->get();
        $this->headers = array_merge($this->headers, $this->departments->pluck('name')->toArray());

        parent::__construct($path, $separator, $enclosure, $escape);
    }

    /**
     * Get the array representation for the given model
     *
     * param  \Illuminate\Database\Eloquent\Model  $model
     * return array
     */
    protected function normalize(Model $passwork): array
    {
        return array_merge(
            $this->getGeneralInformations($passwork),
            $this->getElectricianTechnicianInformations($passwork),
            $this->getElectricianInformations($passwork),
            $this->getOfficeStudiesInformations($passwork),
            [
                37 => $passwork->comment,

            ],
            $this->getCivilEngineeringInformations($passwork),
            $this->getExtraInformations($passwork),
            $this->getPassworkDepartments($passwork)
        );
    }

    /**
     * @param Model $passwork
     * @return array
     */
    private function getGeneralInformations(Model $passwork)
    {
        return [
            0  => $passwork->created_at->format('d/m/Y'),
            1  => remove_accents(__('passwork.passwork.status.' . $passwork->status)),
            2  => $passwork->flag_contacted ? "Oui" : "Non",
            3  => $passwork->user->enterprise->hasTagSoconnext() ? "Oui" : "Non",
            4  => remove_accents($passwork->user->name),
            5  => array_get($passwork->data, 'phone'),
            6  => $passwork->user->email,
            7  => remove_accents(array_get($passwork->data, 'enterprise_name') ?? 'n/a'),
            8  => route('sogetrel.passwork.show', $passwork),
            9  => array_get($passwork->data, 'enterprise_number_of_employees') ?? 'n/a',
            10 => $passwork->user->enterprise->identification_number,
        ];
    }

    /**
     * @param Model $passwork
     * @return array
     */
    private function getExtraInformations(Model $passwork)
    {
        return [
            47 => array_get($passwork->data, 'enterprise_postal_code') ?? 'n/a',
            48 => remove_accents(__('passwork.passwork.sogetrel.' . array_get($passwork->data, 'acquisition', false))),
        ];
    }

    /**
     * Get passwork informations for departments
     *
     * @param Model $passwork
     * @return array
     */
    private function getPassworkDepartments(Model $passwork)
    {
        $array = [];

        foreach ($this->departments as $department) {
            $array[] = $passwork->departments->contains($department) ? '1' : '0';
        }

        return $array;
    }

    /**
     * Get passwork informations for electrician and technician
     *
     * @param Model $passwork
     * @return array
     */
    private function getElectricianTechnicianInformations(Model $passwork)
    {
        return [
            11 => array_get($passwork->data, 'wants_to_work_with.gazpar')                           ? "Oui" : "Non",
            12 => array_get($passwork->data, 'wants_to_work_with.linky')                            ? "Oui" : "Non",
            13 => array_get($passwork->data, 'linky.level') ? remove_accents(__(
                'passwork.passwork.sogetrel.' . array_get($passwork->data, 'linky.level')
            )) : 'n/a',

            14 => array_get($passwork->data, 'wants_to_work_with.erector_rigger_local_loop_cooper') ? "Oui" : "Non",
            15 => array_get($passwork->data, 'erector_rigger_local_loop_cooper.level') ? remove_accents(__(
                'passwork.passwork.sogetrel.'.array_get($passwork->data, 'erector_rigger_d2.level')
            )) : 'n/a',

            16 => array_get($passwork->data, 'wants_to_work_with.subscriber_technician_d3')         ? "Oui" : "Non",
            17 => array_get($passwork->data, 'subscriber_technician_d3.level') ? remove_accents(__(
                'passwork.passwork.sogetrel.'.array_get($passwork->data, 'subscriber_technician_d3.level')
            )) : 'n/a',

            18 => array_get($passwork->data, 'wants_to_work_with.local_loop')                       ? "Oui" : "Non",
            19 => array_get($passwork->data, 'local_loop.level') ? remove_accents(__(
                'passwork.passwork.sogetrel.' . array_get($passwork->data, 'local_loop.level')
            )) : 'n/a',

            20 => array_get($passwork->data, 'wants_to_work_with.erector_rigger_d2')                ? "Oui" : "Non",
            21 => array_get($passwork->data, 'erector_rigger_d2.level') ? remove_accents(__(
                'passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_d2.level')
            )) : 'n/a',
        ];
    }

    private function getElectricianInformations($passwork)
    {
        return [
            23 => array_get($passwork->data, 'wants_to_work_with.optic_fiber')                      ? "Oui" : "Non",
            22 => array_get($passwork->data, 'optic_fiber.level')
                ? remove_accents(__(
                    'passwork.passwork.sogetrel.' . array_get($passwork->data, 'optic_fiber.level')
                )) : 'n/a',

            24 => array_get($passwork->data, 'wants_to_work_with.ftth')                             ? "Oui" : "Non",
            25 => array_get($passwork->data, 'ftth.level')
                ? remove_accents(__('passwork.passwork.sogetrel.' . array_get($passwork->data, 'ftth.level'))) : 'n/a',

            26 => array_get($passwork->data, 'wants_to_work_with.optic_welder')                     ? "Oui" : "Non",
            27 => array_get($passwork->data, 'optic_welder.level')
                ? remove_accents(__(
                    'passwork.passwork.sogetrel.' . array_get($passwork->data, 'optic_welder.level')
                )) : 'n/a',

            28 => array_get($passwork->data, 'wants_to_work_with.cpe_technician')                   ? "Oui" : "Non",
            29 => array_get($passwork->data, 'cpe_technician.level')
                ? remove_accents(__('passwork.passwork.sogetrel.' . array_get($passwork->data, 'cpe_technician.level')))
                : 'n/a',

            30 => array_get($passwork->data, 'wants_to_work_with.erector_rigger_radio')             ? "Oui" : "Non",
            31 => array_get($passwork->data, 'erector_rigger_radio.level')
                ? remove_accents(__(
                    'passwork.passwork.sogetrel.' . array_get($passwork->data, 'erector_rigger_radio.level')
                )) : 'n/a',

            32 => remove_accents($this->getElectricalClearances($passwork)),
        ];
    }

    /**
     * Get level of electrician or technician
     *
     * @param $data
     * @param $key
     * @return mixed|string
     */
    private function getLevel($data, $key)
    {
        return array_get($data, "{$key}.level") ?: 'n/a';
    }

    /**
     * Get passwork informations for office studies
     *
     * @param Model $passwork
     * @return array
     */
    private function getOfficeStudiesInformations(Model $passwork)
    {
        return [
            33 => array_get($passwork->data, 'has_worked_with_in_engineering_office.study_manager')    ? "Oui" : "Non",
            34 => array_get($passwork->data, 'has_worked_with_in_engineering_office.drawer_drafter')   ? "Oui" : "Non",
            35 => array_get($passwork->data, 'has_worked_with_in_engineering_office.telecom_picketer') ? "Oui" : "Non",
            36 => remove_accents(array_get($passwork->data, 'qualifications', false) ?? "n/a"),
        ];
    }

    /**
     * Get passwork informations for civil engineering
     *
     * @param Model $passwork
     * @return array
     */
    protected function getCivilEngineeringInformations(Model $passwork)
    {
        return [
            38 => in_array('office_studies', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            39 => in_array('vrd', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            40 => in_array('repair', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            41 => in_array('posts_with_auger', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            42 => in_array('posts_with_hands', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            43 => in_array('street_cabinets', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            44 => in_array('telecom_room', array_get($passwork->data, 'has_worked_with_in_civil_engineering', []))
                ? "Oui" : "Non",
            45 => in_array(
                'trenchless_networks',
                array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])
            ) ? "Oui" : "Non",
            46 => in_array(
                'management_procedures',
                array_get($passwork->data, 'has_worked_with_in_civil_engineering', [])
            ) ? "Oui" : "Non",
        ];
    }

    /**
     * Get electrical clearances
     *
     * @param Model $passwork
     * @return string
     */
    private function getElectricalClearances(Model $passwork)
    {
        if (!array_get($passwork->data, 'electrical_clearances')) {
            return "";
        }

        $collection = collect(array_get($passwork->data, 'electrical_clearances', []));
        $other = array_get($passwork->data, 'electrical_clearances_other');

        return $collection->reduce(function ($carry, $item) use ($other) {
            return $carry . "- {$item} " . ($item == 'other'? ": " . $other : "");
        }, "");
    }
}
