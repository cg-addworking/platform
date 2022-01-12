<?php

namespace App\Repositories\Soprema\Enterprise;

use App\Contracts\Models\Repository;
use App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer\StoreCovid19FormAnswerRequest;
use App\Http\Requests\Soprema\Enterprise\Covid19FormAnswer\UpdateCovid19FormAnswerRequest;
use App\Repositories\BaseRepository;
use App\Models\Soprema\Enterprise\Covid19FormAnswer;

class Covid19FormAnswerRepository extends BaseRepository
{
    protected $model = Covid19FormAnswer::class;

    public function createFromRequest(StoreCovid19FormAnswerRequest $request): Covid19FormAnswer
    {
        return tap($this->make($request->input('covid19_form_answer', [])), function ($answer) use ($request) {
            if ($vendor_id = $request->input('covid19_form_answer.vendor_id')) {
                $answer->vendor()->associate($vendor_id);
            }

            if ($customer_id = $request->input('covid19_form_answer.customer_id')) {
                $answer->customer()->associate($customer_id);
            }

            $answer->save();
        });
    }

    public function updateFromRequest(
        UpdateCovid19FormAnswerRequest $request,
        Covid19FormAnswer $covid19_form_answer
    ): Covid19FormAnswer {
        return $this->update($covid19_form_answer, $request->input('covid19_form_answer', []));
    }
}
