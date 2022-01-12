<?php

use App\Models\Sogetrel\User\Passwork;
use Faker\Generator as Faker;

$factory->define(Passwork::class, function (Faker $faker) {
    return [
        'status'         => sogetrel_passwork()::STATUS_PENDING,
        'flag_parking'   => false,
        'flag_contacted' => false,
        'data'           => [
            "electrician"                              => "0",
            "multi_activities"                         => "0",
            "engineering_office"                       => "0",
            "years_of_experience"                      => "less_than_1",
            "independant"                              => "0",
            "phone"                                    => "0836656565",
            "wants_to_be_independant"                  => "0",
            "enterprise_name"                          => null,
            "enterprise_number_of_employees"           => null,
            "years_of_experience_as_independant"       => null,
            "study_manager"                            => [
                "years_of_experience" => null,
            ],
            "drawer"                                   => [
                "years_of_experience" => null,
            ],
            "drawer_drafter"                           => [
                "years_of_experience" => null,
            ],
            "telecom_picketer"                         => [
                "years_of_experience" => null,
                "other_experience"    => [],
            ],
            "gazpar"                                   => [
                "trained" => null,
            ],
            "linky"                                    => [
                "trained"     => null,
                "level"       => null,
                "deposit"     => null,
                "programming" => null,
                "maintenance" => null,
            ],
            "ftth"                                     => [
                "level"                    => null,
                "read_electric_blueprints" => null,
                "read_wiring_blueprints"   => null,
                "differentiate_cables"     => null,
                "cable_connection_rules"   => null,
                "electrical_measures"      => null,
                "optical_measures"         => null,
            ],
            "optic"                                    => [
                "level"                          => null,
                "understands_measurment_curve"   => null,
                "understands_cable_blueprint"    => null,
                "differenciates_cables"          => null,
                "understance_optic_fiber_basics" => null,
                "masters_connection_tools"       => null,
                "masters_measuring_tools"        => null,
            ],
            "local_loop"                               => [
                "level"                       => null,
                "years_of_experience"         => null,
                "reads_blueprints"            => null,
                "understands_cable_blueprint" => null,
                "differenciates_cables"       => null,
                "cable_connection_rules"      => null,
                "electrical_measures"         => null,
                "optical_measures"            => null,
            ],
            "erector_rigger_local_loop_cooper"         => [
                "level"                       => null,
                "years_of_experience"         => null,
                "reads_blueprints"            => null,
                "understands_cable_blueprint" => null,
                "differenciates_cables"       => null,
                "cable_connection_rules"      => null,
                "electrical_measures"         => null,
            ],
            "erector_rigger_radio"                     => [
                "level"                                    => null,
                "reads_blueprints"                         => null,
                "realization_cable_trays"                  => null,
                "coaxial_connector_grounding_installation" => null,
                "connection_radio_equipment"               => null,
                "work_height_pylon_roof_water_tower"       => null,
            ],
            "cpe_technician"                           => [
                "level"                              => null,
                "installation_rules_commissioning"   => null,
                "wiring_installation_commissioning"  => null,
                "measurements_with_specific_devices" => null,
            ],
            "optic_welder"                             => [
                "level"                         => null,
                "understands_cable_blueprint"   => null,
                "differenciates_cables"         => null,
                "masters_optic_cable_rules"     => null,
                "masters_welding"               => null,
                "master_welder_tool"            => null,
                "masters_measuring_tools"       => null,
                "masters_optic_measuring_tools" => null,
            ],
            "electrical_clearances_other"              => null,
            "qualifications"                           => null,
            "caces"                                    => null,
            "e_type_driving_license"                   => null,
            "rc_pro"                                   => "0",
            "insurance"                                => "0",
            "availability"                             => "half_a_day",
            "acquisition"                              => "email",
            "acquisition_other"                        => null,
            "departments"                              => [],
            "has_worked_with"                          => [],
            "wants_to_work_with"                       => [],
            "has_worked_with_in_engineering_office"    => [],
            "wants_to_work_with_in_engineering_office" => [],
            "engineering_office_software"              => [
                "dao_software"      => [],
                "sig_software"      => [],
                "business_software" => [],
            ],
        ],
    ];
});

$factory->state(Passwork::class, 'pending', [
    'status' => Passwork::STATUS_PENDING,
]);

$factory->state(Passwork::class, 'accepted', [
    'status' => Passwork::STATUS_ACCEPTED,
]);

$factory->state(Passwork::class, 'refused', [
    'status' => Passwork::STATUS_REFUSED,
]);

$factory->state(Passwork::class, 'parked', [
    'flag_parking' => true,
]);

$factory->state(Passwork::class, 'contacted', [
    'flag_contacted' => true,
]);
