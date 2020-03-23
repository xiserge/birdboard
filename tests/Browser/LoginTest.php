<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testExample()
    {
        dd();
        $password = '123';
        $user = factory(\App\User::class)->create([
            'password' => Hash::make($password),
        ]);

        $this->browse(function (Browser $browser) use($user, $password) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', $password)
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertSee($user->name);
        });
    }
}
