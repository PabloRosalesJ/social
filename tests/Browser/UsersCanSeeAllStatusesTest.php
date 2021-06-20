<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function users_can_see_all_users_on_homepage()
    {
        $statuses = factory(Status::class, 4)->create(['created_at' => now()->subMinute()]);
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $statuses) {

            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($statuses->first()->body);

            foreach ($statuses as $status) {
                $browser->assertSee($status->body)
                    ->assertSee($status->user->name)
                    ->assertSee($status->created_at->diffForHumans());
            }
        });
    }
}
