<?php

namespace Tests\Unit\App\Http\Requests\Addworking\Common\Passwork;

use App\Http\Requests\Addworking\Common\Passwork\StorePassworkRequest;
use Tests\TestCase;

class StorePassworkRequestTest extends TestCase
{
    protected $form_request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->form_request = new StorePassworkRequest();
    }

    public function testAuthorize()
    {
        $this->assertTrue($this->form_request->authorize());
    }

    public function testRules()
    {
        $this->assertEquals(
            ['customer.id' => "required|uuid||exists:addworking_enterprise_enterprises,id",],
            $this->form_request->rules()
        );
    }
}
