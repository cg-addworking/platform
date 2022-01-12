<?php

namespace Tests\Unit\App\Repositories\Addworking\Contract;

use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Contract\ContractTemplateRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class ContractTemplateRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testList()
    {
        $repo = app(ContractTemplateRepository::class);
        $contract_template = factory(ContractTemplate::class)->create();

        $this->assertEquals($repo->list()->count(), 1);
    }

    public function createFromRequest()
    {
        $contract_template = factory(ContractTemplate::class)->make();

        $requestParams = [
            'contract_template' => $contract_template,
        ];

        $request = Request::create(
            '/addworking/enterprise/{$contract_template->enterprise_id}/contract_template',
            'POST',
            $requestParams
        );

        $repo = app(ContractTemplateRepository::class);
        $template = $repo->createFromRequest($request);

        $this->assertTrue($template->exists);
    }
}
