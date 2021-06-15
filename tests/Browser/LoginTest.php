<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * @test
     * @throws \Throwable
     */
    public function a_user_registered_can_login()
    {
        factory(User::class)->create(['email' => 'pablo@mail.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'pablo@mail.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/')
                ->assertAuthenticated();
            ;
        });
    }
}
