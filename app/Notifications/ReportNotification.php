<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $date_from;
    private $date_to;
    private $token;
    private $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($date_from, $date_to, $token, $user_id)
    {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->token = $token;
        $this->user_id = $user_id;
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
        return (new MailMessage)
                    ->from (env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Report Notification')
                    ->greeting('Dear customer,')
                    ->line('Here is your requested report.')
                    ->line('Click on the button below to open your report.')
                    ->action('Open Report', url(env('APP_URL').'report/'.$this->token))
                    ->line('Thank you for using our application!');
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
