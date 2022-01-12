<?php

namespace Tests\Unit\App\Models\Edenred\Common;

use App\Models\Edenred\Common\Code;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CodeTest extends TestCase
{
    use RefreshDatabase;

    public function testScopeFilterSkill()
    {
        $code = tap(factory(Code::class)->create(), function ($code) {
            $code->skill->update(['display_name' => 'foo bar']);
        });

        $this->assertEquals(
            1,
            Code::filterSkill('foo')->count(),
            'We should find the code by the skill display_name'
        );

        $this->assertEquals(
            0,
            Code::filterSkill('dingo')->count(),
            'We should find 0 code by this search term'
        );
    }

    public function testScopeFilterJob()
    {
        $code = tap(factory(Code::class)->create(), function ($code) {
            $code->job->update(['display_name' => 'foo bar']);
        });

        $this->assertEquals(
            1,
            Code::filterJob('foo')->count(),
            'We should find the code by the skill job display_name'
        );

        $this->assertEquals(
            0,
            Code::filterJob('dingo')->count(),
            'We should find 0 code by this search term'
        );
    }

    public function testScopeSearch()
    {
        $code = tap(factory(Code::class)->create(['code' => 'dev']), function ($code) {
            $code->skill->update(['display_name' => 'foo bar']);
            $code->job->update(['display_name' => 'baz quxx']);
        });

        $this->assertEquals(
            1,
            Code::search('de')->count(),
            'We should find the code by its code attribute'
        );

        $this->assertEquals(
            1,
            Code::search('qu')->count(),
            'We should find the code by the skill job display_name'
        );

        $this->assertEquals(
            1,
            Code::search('oo')->count(),
            'We should find the code by the skill display_name'
        );

        $this->assertEquals(
            0,
            Code::search('dingo')->count(),
            'We should find 0 code by this search term'
        );
    }
}
