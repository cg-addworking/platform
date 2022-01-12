<?php

namespace App\Http\Requests\Edenred\Common\AverageDailyRate;

use App\Models\Edenred\Common\AverageDailyRate;
use Illuminate\Foundation\Http\FormRequest;

class StoreAverageDailyRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', AverageDailyRate::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
