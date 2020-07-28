<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PartnerQuestionnaireNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     public $partner;
    public function __construct($p)
    {
        $this->partner=$p;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
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
        //$url = url('/ethics/partnerQuestionForm/'.$this->partner->uuid);
        $url =URL::temporarySignedRoute('partnerQuestionForm',now()->addMinutes(config('ethics.registration_validity')),['id'=>$this->partner->uuid]);
        return (new MailMessage)

                    ->greeting('Dear Sir/Madam,')
                    ->line('Please fill the Business Partner Questionnaire in the following link at earliest .')
                    ->action('Click here', $url)
                    ->line('This link will expire in.'.config('ethics.registration_validity').' hours')
                    ->line('This is an automatically generated mail from Business Partner Portal.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
