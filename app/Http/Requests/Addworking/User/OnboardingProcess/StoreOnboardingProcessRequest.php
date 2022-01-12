<?php

namespace App\Http\Requests\Addworking\User\OnboardingProcess;

use App\Models\Addworking\User\OnboardingProcess;
use Illuminate\Foundation\Http\FormRequest;

class StoreOnboardingProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', OnboardingProcess::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'onboarding_process.user'       => 'required|uuid|exists:addworking_user_users,id',
            'onboarding_process.enterprise' => 'required|uuid|exists:addworking_enterprise_enterprises,id',
            'onboarding_process.complete'   => 'string',
        ];
    }
}
