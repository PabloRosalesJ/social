<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Model\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_statust_belongs_to_a_user()
    {
        $status  = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user);
    }
}
