<?php

namespace Tests\Unit\Http\Resource;

use App\Http\Resources\StatusResource;
use Tests\TestCase;
use App\Model\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_resource_test_must_have_the_nessesary_fields()
    {
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

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
    }
}
