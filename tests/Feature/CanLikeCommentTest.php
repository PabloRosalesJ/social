<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_user_can_not_like_comment()
    {
        $comment = factory(Comment::class)->create();

        $response = $this->postJson(route('comment.likes.store', $comment));

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_like_and_unlike_comment()
    {
        //$this->markTestIncomplete();
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->assertCount(0, $comment->likes);

        $this->actingAs($user)->postJson(route('comment.likes.store', $comment));

        $this->assertCount(1, $comment->fresh()->likes);

        $this->assertDatabaseHas('likes', ['user_id' => $user->id]);

        $this->actingAs($user)->deleteJson(route('comment.likes.destroy', $comment));

        $this->assertCount(0, $comment->likes);

        $this->assertDatabaseMissing('likes', ['user_id' => $user->id]);
    }
}
