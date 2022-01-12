<?php

namespace Tests\Unit\App\Http\Requests\Addworking\Contract\ContractTemplate;

use App\Http\Requests\Addworking\Contract\ContractTemplate\UpdateContractTemplateRequest;
use App\Models\Addworking\Contract\ContractTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateContractTemplateRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testRules()
    {
        $request = new UpdateContractTemplateRequest();

        $contract_template = factory(ContractTemplate::class)->make();

        $inputs = [
            'contract_template' => [
                'name'         => $contract_template->name,
                'display_name' => $contract_template->display_name,
            ],
        ];

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->passes());
    }
}
