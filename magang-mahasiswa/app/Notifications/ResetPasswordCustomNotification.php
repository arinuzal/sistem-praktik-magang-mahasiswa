<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCustomNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password Kamu - Sistem Praktik Magang Mahasiswa')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Kami menerima permintaan reset password untuk akun kamu.')
            ->action('Reset Password Sekarang', $url)
            ->line('Kalau kamu tidak meminta reset password, abaikan email ini.')
            ->salutation('Terima kasih 🙏');
    }
}

