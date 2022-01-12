<?php

namespace Tests\Unit\App\Models\Addworking\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContractTest extends TestCase
{
    use  RefreshDatabase;

    public function testScopeValidFrom()
    {
        factory(Contract::class, 5)->create(['valid_from' => date('Y-m-d', strtotime('-1 week'))]);

        factory(Contract::class, 7)->create(['valid_from' => date('Y-m-d', strtotime('-3 days'))]);

        $this->assertEquals(
            5,
            Contract::validFrom(date('Y-m-d', strtotime('-1 week')))->count(),
            'Thes should be only 5 contracts with the given valid_from date'
        );
    }

    public function testScopeValidUntil()
    {
        factory(Contract::class, 3)->create(['valid_until' => date('Y-m-d', strtotime('+3 weeks'))]);

        factory(Contract::class, 5)->create(['valid_until' => date('Y-m-d', strtotime('+2 days'))]);

        $this->assertEquals(
            5,
            Contract::validUntil(date('Y-m-d', strtotime('+2 days')))->count(),
            'Thes should be only 5 contracts with the given valid_until date'
        );
    }

    public function testFromSigningHubPackage()
    {
        factory(Contract::class)->create([
            'signinghub_package_id' => $id = uniqid()
        ]);

        $this->assertTrue(
            Contract::fromSigningHubPackage($id)->exists,
            "There should be one contract for this SigningHub package id"
        );
    }

    public function testIsDraft()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_DRAFT]);

        $this->assertTrue(
            $contract->isDraft(),
            "Contract status should be draft"
        );
    }

    public function testIsReadyToGenerate()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_READY_TO_GENERATE]);

        $this->assertTrue(
            $contract->isReadyToGenerate(),
            "Contract status should be ready to generate"
        );
    }

    public function testIsGenerating()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_GENERATING]);

        $this->assertTrue(
            $contract->isGenerating(),
            "Contract status should be generating"
        );
    }

    public function testIsGenerated()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_GENERATED]);

        $this->assertTrue(
            $contract->isGenerated(),
            "Contract status should be generated"
        );
    }

    public function testIsUploading()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_UPLOADING]);

        $this->assertTrue(
            $contract->isUploading(),
            "Contract status should be uploading"
        );
    }

    public function testIsUploaded()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_UPLOADED]);

        $this->assertTrue(
            $contract->isUploaded(),
            "Contract status should be uploaded"
        );
    }

    public function testIsReadyToSign()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_READY_TO_SIGN]);

        $this->assertTrue(
            $contract->isReadyToSign(),
            "Contract status should be ready to sign"
        );
    }

    public function testIsBeingSigned()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_BEING_SIGNED]);

        $this->assertTrue(
            $contract->isBeingSigned(),
            "Contract status should be being signed"
        );
    }

    public function testIsCancelled()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_CANCELLED]);

        $this->assertTrue(
            $contract->isCancelled(),
            "Contract status should be cancelled"
        );
    }

    public function testIsActive()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_ACTIVE]);

        $this->assertTrue(
            $contract->isActive(),
            "Contract status should be active"
        );
    }

    public function testIsInactive()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_INACTIVE]);

        $this->assertTrue(
            $contract->isInactive(),
            "Contract status should be inactive"
        );
    }

    public function testIsExpired()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_EXPIRED]);

        $this->assertTrue(
            $contract->isExpired(),
            "Contract status should be expired"
        );
    }

    public function testIsError()
    {
        $contract = factory(Contract::class)->create(['status' => Contract::STATUS_ERROR]);

        $this->assertTrue(
            $contract->isError(),
            "Contract status should be error"
        );
    }
}
