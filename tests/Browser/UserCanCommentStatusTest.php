<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCommentStatusTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function users_can_see_all_comments()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class, 2)->create(['status_id' => $status->id]);

        $this->browse(function (Browser $browser) use ($status, $comments) {
            $browser->visit('/')->waitForText($status->body);
            foreach ($comments as $comment) {
                $browser
                    ->assertSee($comment->body)
                    ->assertSee($comment->user->name);
            }
        });
    }

    /**
     * @test
     */
    public function authenticated_user_can_comment_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $comment = 'Mi primer comentario';
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->type('comment', $comment)
                ->press('@comment-btn')
                ->waitForText($comment)
                ->assertSee($comment);
        });
    }
}
