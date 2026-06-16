<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class verifyEmail extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]);

        return new MailMessage()->subject('Confirma tu cuenta en CashTrackr')
        ->greeting("Hola")
        ->line('Gracias por registrarte en CashTrackr, tu cuenta ya esta lista!, solo debes confirmarla.')
        ->action('Confirma tu cuenta', $verificationUrl)
        ->line('Si tu no creaste esta cuenta, puedes ignorar este correo.')
        ->line('Gracias por usar Cash Trackr!');
    }
}
