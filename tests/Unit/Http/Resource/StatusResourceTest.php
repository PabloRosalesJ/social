<?php

namespace Tests\Unit\Http\Resource;

use App\Http\Resources\CommentResource;
use App\Http\Resources\StatusResource;
use App\Models\Comment;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_resource_status_must_have_the_nessesary_fields()
    {
        $status = factory(Status::class)->create();
        factory(Comment::class)->create(['status_id' => $status->id]);

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals(
            $status->id,
            $statusResource['id']
        );

        $this->assertEquals(
            $status->body,
            $statusResource['body']
        );

        $this->assertEquals(
            $status->user->name,
            $statusResource['user_name']
        );

        $this->assertEquals(
            'https://dummyimage.com/40x40/5e6e9e/ffffff&text=P%20R', //$status->user->avatar,
            $statusResource['user_avatar']
        );

        $this->assertEquals(
            $status->created_at->diffForHumans(),
            $statusResource['ago']
        );

        $this->assertEquals(
            false,
            $statusResource['is_liked']
        );

        $this->assertEquals(
            0,
            $statusResource['likes_count']
        );

        $this->assertEquals(
            CommentResource::class,
            $statusResource['comments']->collects
        );

        $this->assertInstanceOf(
            Comment::class,
            $statusResource['comments']->first()->resource
        );
    }
}
