<?php

namespace Tests\Unit\App\Models\Addworking\Common;

use App\Models\Addworking\Common\Folder;
use Components\Infrastructure\Foundation\Application\Test\ModelTestCase;

class FolderTest extends ModelTestCase
{
    protected $class = Folder::class;

    public function testScopeFilterUser()
    {
        $folder = tap(factory(Folder::class)->create(), function ($folder) {
            $folder->createdBy->update([
                'firstname' => 'john',
                'lastname' => 'DOE',
            ]);
        });

        $this->assertEquals(
            1,
            Folder::filterUser('jo')->count(),
            'We should find the folder by creator firstname'
        );

        $this->assertEquals(
            1,
            Folder::filterUser('oe')->count(),
            'We should find the folder by creator lastname'
        );

        $this->assertEquals(
            0,
            Folder::filterUser('foo')->count(),
            'We should find 0 folder by this search term'
        );
    }

    public function testScopeSearch()
    {
        $folder = tap(factory(Folder::class)->create(['display_name' => 'foo bar']), function ($folder) {
            $folder->createdBy->update([
                'firstname' => 'john',
                'lastname' => 'DOE',
            ]);
        });

        $this->assertEquals(
            1,
            Folder::search('jo')->count(),
            'We should find the folder by creator firstname'
        );

        $this->assertEquals(
            1,
            Folder::search('oe')->count(),
            'We should find the folder by creator lastname'
        );

        $this->assertEquals(
            1,
            Folder::search('bar')->count(),
            'We should find the folder by display_name'
        );

        $this->assertEquals(
            0,
            Folder::search('dingo')->count(),
            'We should find 0 folder by this search term'
        );
    }
}
