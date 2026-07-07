<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            return (new MailMessage)
                ->subject('Reset Password Sasak Sade')
                ->greeting('Halo!')
                ->line('Kami menerima permintaan reset password untuk akun Sasak Sade Anda.')
                ->action('Reset Password', $url)
                ->line('Link ini berlaku selama '.config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' menit.')
                ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
        });

        View::composer('*', function ($view) {
            $authUser = session('auth_user');
            $bookingCount = 0;

            if ($authUser && isset($authUser['id'])) {
                $bookingCount = Booking::where('user_id', $authUser['id'])->count();
            }

            $view->with('authUser', $authUser)->with('bookingNotificationCount', $bookingCount);
        });
    }
}
