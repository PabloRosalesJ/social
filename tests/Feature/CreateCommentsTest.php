<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_user_can_not_comment_status()
    {
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson(route('status.comment.store', $status), $comment);

        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function authenticated_user_can_comment_status()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)
            ->postJson(route('status.comment.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']]
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);
    }
}
