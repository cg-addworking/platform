<?php

namespace App\Models\Addworking\Common;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\HtmlString;

class CommentCollection extends Collection implements Htmlable
{
    public function __toString()
    {
        return (string) $this->toHtml();
    }

    public function toHtml(): HtmlString
    {
        $html = view('addworking.common.comment._collection', [
            'comments' => $this->sortByDesc('created_at')
        ])->render();

        return new HtmlString($html);
    }
}
