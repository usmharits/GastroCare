<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Tambahin 3 baris ini buat narik class email bawaan Laravel
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ==========================================================
        // 1. CUSTOM EMAIL VERIFIKASI (Pas baru daftar)
        // ==========================================================
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email Akun Pakar GERD Kamu! 🚀')
                ->greeting('Halo, Sobat Sehat!')
                ->line('Terima kasih udah daftar di aplikasi Pakar GERD. Tinggal selangkah lagi nih buat mantau kesehatan lambungmu.')
                ->line('Silakan klik tombol di bawah ini untuk verifikasi alamat email kamu ya.')
                ->action('Verifikasi Email Sekarang', $url)
                ->line('Kalau kamu merasa nggak pernah daftar di aplikasi ini, abaikan aja email ini bro!')
                ->salutation('Salam Sehat, Tim Pakar GERD');
        });

        // ==========================================================
        // 2. CUSTOM EMAIL RESET PASSWORD (Pas lupa password)
        // ==========================================================
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            // Laravel otomatis nge-generate URL reset password-nya
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Reset Password Pakar GERD 🔐')
                ->greeting('Halo!')
                ->line('Kamu menerima email ini karena kami mendapat permintaan untuk reset password akun kamu.')
                ->action('Reset Password', $url)
                ->line('Link reset password ini bakal kedaluwarsa dalam 60 menit.')
                ->line('Kalau kamu nggak pernah minta reset password, cuekin aja email ini, akunmu tetap aman kok.')
                ->salutation('Salam Sehat, Tim Pakar GERD');
        });
    }
}