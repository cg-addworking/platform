<?php

namespace App\Http\Requests\Sogetrel\User\Passwork;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\RequiredIfWithLoop;
use App\Rules\HasAJob;

/**
 * Class StorePasswork
 * @package App\Http\Requests\Sogetrel\User\Passwork
 */
class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'passwork.data.electrician'                          => "required",
            'passwork.data.multi_activities'                     => "required",
            'passwork.data.technicien_cavi'                      => "required",
            'passwork.data.engineering_office'                   => "required",
            'passwork.data.civil_engineering'                    => "required",
            'passwork.data.years_of_experience'                  => "required",
            'passwork.data.independant'                          => "required",
            'passwork.data.phone'                                => "required|french_phone_number",
            'departments'                                        => "required|array",
            'file.content'                                       => "file|min:1|mimes:pdf|max:4000",
            'passwork.data.has_worked_with_in_engineering_office'=> "required_if:passwork.data.engineering_office,==,1",
            'passwork.data.enterprise_postal_code'               => "required_if:passwork.data.independant,==,1",
            'passwork.data.wants_to_work_with'                   => "required_if:passwork.data.multi_activities,==,1",
            'passwork.data.electrical_clearances.0'              =>
                "required_if:passwork.data.electrician,==,1",
            'passwork.data.has_worked_with_in_civil_engineering'=> "
                required_if:passwork.data.civil_engineering,==,1",

            'passwork.data' => [
                new HasAJob($this->request->get('passwork')['data'])
            ],

            'passwork.data.study_manager.years_of_experience' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['has_worked_with_in_engineering_office'] ?? null,
                    'study_manager'
                )
            ],

            'passwork.data.telecom_picketer.years_of_experience' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['has_worked_with_in_engineering_office'] ?? null,
                    'telecom_picketer'
                )
            ],

            'passwork.data.linky.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'linky'
                )
            ],

            'passwork.data.erector_rigger_local_loop_cooper.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'erector_rigger_local_loop_cooper'
                )
            ],

            'passwork.data.optic.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'optic_fiber'
                )
            ],

            'passwork.data.local_loop.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'local_loop'
                )
            ],

            'passwork.data.erector_rigger_d2.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'erector_rigger_d2'
                )
            ],

            'passwork.data.ftth.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'ftth'
                )
            ],

            'passwork.data.cpe_technician.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'cpe_technician'
                )
            ],

            'passwork.data.subscriber_technician_d3.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'subscriber_technician_d3'
                )
            ],

            'passwork.data.optic_welder.level' => [
                new RequiredIfWithLoop(
                    $this->request->get('passwork')['data']['wants_to_work_with'] ?? null,
                    'optic_welder'
                )
            ],
        ];
    }
}
