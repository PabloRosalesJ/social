<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Models\Comment;
use App\Traits\HasLikes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_comment_belongs_to_a_user()
    {
        $comment = factory(Comment::class)->create();
        $this->assertInstanceOf(User::class, $comment->user);
    }

    /**
     * @test
     */
    public function an_comment_model_must_use_the_trait_has_likes()
    {
        $this->assertClassUseTrait(HasLikes::class, Comment::class);
    }
}
