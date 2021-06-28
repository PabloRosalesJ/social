<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLikeCommentsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function an_authenticated_user_can_like_an_comment()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comment-likes-count', 0)
                ->press('@comment-like-btn')
                ->waitForText('TE GUSTA')
                ->assertSee('TE GUSTA')
                ->waitForText(1)
                ->assertSeeIn('@comment-likes-count', 1)
                ->press('@comment-like-btn')
                ->waitForText('ME GUSTA')
                ->assertSee('ME GUSTA')
                ->waitForText(0)
                ->assertSeeIn('@comment-likes-count', 0);
        });
    }
}
