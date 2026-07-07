<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

test('forgot password page can be viewed', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('Lupa Password');
});

test('reset link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), [
        'email' => $user->email,
    ])->assertRedirect();

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password can be reset with a valid token', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::createToken($user);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertRedirect(route('login'));

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});
