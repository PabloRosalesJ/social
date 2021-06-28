<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeStatusesTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_users_can_not_like_statuses()
    {
        $this->withoutExceptionHandling();

        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->assertPathIs('/login');
        });
    }

    /**
     * @test
     */
    public function users_can_like_and_unlike_statuses()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->waitForText('TE GUSTA')
                ->assertSee('TE GUSTA')
                ->waitForText(1)
                ->assertSeeIn('@likes-count', 1)
                ->press('@like-btn')
                ->waitForText('ME GUSTA')
                ->assertSee('ME GUSTA')
                ->assertSeeIn('@likes-count', 0);
        });
    }
}
