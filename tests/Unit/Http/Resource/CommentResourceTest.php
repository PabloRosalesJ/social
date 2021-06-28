<?php

namespace Tests\Unit\Http\Resource;

use Tests\TestCase;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_resource_comment_must_have_the_nessesary_fields()
    {
        $comment = factory(Comment::class)->create();

        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals(
            $comment->id,
            $commentResource['id']
        );

        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );

        $this->assertEquals(
            $comment->user->name,
            $commentResource['user_name']
        );

        $this->assertEquals(
            'https://dummyimage.com/40x40/5e6e9e/ffffff&text=P%20R',
            $commentResource['user_avatar']
        );

        $this->assertEquals(
            $comment->likesCount(),
            $commentResource['likes_count']
        );

        $this->assertEquals(
            $comment->isLiked(),
            $commentResource['is_liked']
        );
    }

    /** @test */
    public function a_comment_requires_a_body()
    {
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('status.comment.store', $comment), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
