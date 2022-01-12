<?php

namespace App\Repositories\Edenred\Common;

use App\Models\Edenred\Common\Code;
use App\Repositories\Addworking\Common\SkillRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CodeRepository extends BaseRepository
{
    protected $model = Code::class;

    protected $skill;

    public function __construct(SkillRepository $skill)
    {
        $this->skill = $skill;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Code::query()
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request): Code
    {
        $code = $this->make($request->input('code'));
        $skill = $this->skill->find($request->input('skill.id'));
        $code->skill()->associate($skill);
        $code->save();

        return $code;
    }

    public function updateFromRequest(Request $request, Code $code): Code
    {
        $this->update($code, $request->input('code'));
        $skill = $this->skill->find($request->input('skill.id'));
        $code->skill()->associate($skill);
        $code->save();

        return $code;
    }
}
