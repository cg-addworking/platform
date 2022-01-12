<?php

namespace Tests\Unit\App\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ConfirmationBpuTest extends TestCase
{
    public function testMail()
    {
        Mail::fake();

        $this->assertTrue(true);
    }
}
