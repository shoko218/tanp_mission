<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetNotification extends ResetPassword
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
        ->subject('パスワードをリセットする')
        ->view('mail.resetpass', [
            'reset_url' => url(config('constant.domain').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false))
        ]);
    }
}