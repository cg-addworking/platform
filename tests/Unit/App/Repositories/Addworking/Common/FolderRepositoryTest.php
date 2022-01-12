<?php

namespace Tests\Unit\App\Repositories\Addworking\Common;

use App\Models\Addworking\Common\Folder;
use App\Repositories\Addworking\Common\FolderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FolderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testList()
    {
        $repo = app(FolderRepository::class);
        $folders = factory(Folder::class, 3)->create();

        $this->assertEquals($repo->list()->count(), 3);
    }
}
