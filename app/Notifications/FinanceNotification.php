<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $partner;
    public function __construct($p)
    {
        $this->partner=$p;
    }   


    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/ethics?q=detail/'.$this->partner->uuid);
        return (new MailMessage)
                    ->subject('Business Partner Review')
                    ->greeting('Dear Sir/Madam,')
                    ->line('Business Partner Registration requires your review.Click on the following link to review')
                    ->action('Click here', $url)
                    ->line('This is an automatically generated mail from Business Partner Portal.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
