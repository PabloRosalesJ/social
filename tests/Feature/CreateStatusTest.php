<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_users_cant_not_create_statuses_test()
    {
        $response = $this->postJson(route('statuses.store'), ['body' => 'First status']);

        $response->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_create_test()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $reponse = $this->post(route('statuses.store'), [
            'body' => 'First status'
        ]);

        $reponse->assertJson([
            'data' => ['body' => 'First status']
        ]);

        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'First status',
        ]);
    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    public function a_status_body_require_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '1234']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
