<?php

namespace Tests\Unit\App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Enterprise\DocumentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdate()
    {
        $policy   = $this->app->make(DocumentPolicy::class);
        $user     = factory(User::class)->state('support')->create();
        $document = factory(Document::class)->create();

        $this->assertTrue(
            $policy->update($user, $document)->allowed(),
            "Support user should be allowed to edit document"
        );

        $this->assertTrue(
            $policy->update($document->enterprise->users()->first(), $document)->denied(),
            "Owner of the document should not be allowed to edit document"
        );
    }
}
