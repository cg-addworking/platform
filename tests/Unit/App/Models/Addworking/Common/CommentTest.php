<?php

namespace Tests\Unit\App\Models\Addworking\Common;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testCommentable()
    {
        $comment = factory(Comment::class)->create();

        $this->assertSame($comment['commentable_type'], get_class($comment->commentable()->first()));
    }

    public function testAuthor()
    {
        $comment = factory(Comment::class)->create();

        $this->assertEquals($comment['author_id'], $comment->author->id);
    }

    public function testSetVisibilityAttribute()
    {
        $comment = factory(Comment::class)->create();

        $comment->setVisibilityAttribute(Comment::VISIBILITY_PUBLIC);
        $this->assertEquals($comment['visibility'], Comment::VISIBILITY_PUBLIC);

        $comment->setVisibilityAttribute(Comment::VISIBILITY_PRIVATE);
        $this->assertEquals($comment['visibility'], Comment::VISIBILITY_PRIVATE);

        $comment->setVisibilityAttribute(Comment::VISIBILITY_PROTECTED);
        $this->assertEquals($comment['visibility'], Comment::VISIBILITY_PROTECTED);
    }

    public function testGetContentHtmlAttribute()
    {
        $comment = factory(Comment::class)->create();
        $comment->content = "Hello\r\nworld !";

        $this->assertStringContainsString('<br />', $comment->getContentHtmlAttribute());
    }

    public function testScopeOfAuthor()
    {
        $users = factory(User::class, 5)->create()->each(function ($user) {
            factory(Comment::class, 2)->make()->each(function ($comment) use ($user) {
                $comment->author()->associate($user)->save();
            });
        });

        $this->assertCount(
            10,
            Comment::all(),
            "There should be 10 comments in the database"
        );

        $this->assertCount(
            2,
            Comment::ofAuthor($users->first()->id)->get(),
            "First author should have written 2 comments"
        );

        foreach ($users as $user) {
            $this->assertCount(
                2,
                Comment::ofAuthor($user)->get(),
                "Each author should have 2 comments"
            );
        }

        $this->assertCount(
            10,
            Comment::ofAuthor($users)->get(),
            "All authors should have written 10 comments"
        );

        $this->assertCount(
            10,
            Comment::ofAuthor($users->pluck('id')->toArray())->get(),
            "All authors should have written 10 comments"
        );
    }
}
