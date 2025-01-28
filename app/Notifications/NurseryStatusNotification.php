<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NurseryStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $token, public $status)
    {
        $this->token = $token;
        $this->status = $status;
    }

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
        $url = env('FRONTEND_URL') . 'token=' . $this->token . '&&email=' . $notifiable->email;
        if ($this->status == 'approved') {
            return (new MailMessage)
                ->greeting('Welcome ' . $notifiable->name . ',')
                ->line('Your nursery is now officially part of the Infancia network, and you can start using our platform to manage and promote your services.')
                ->line('If you have any questions or need further assistance, please do not hesitate to contact us:')
                ->line('**Email:** [info@infancia.com](mailto:info@infancia.com)')
                ->line('**Phone:** +202 22746241')
                ->action('Login here', $url)
                ->line('---')
                ->line('Thank you for choosing **Infancia**. We are excited to support your nursery on this journey.')
                ->salutation("Best regards, **Infancia's** Team");
        } else if ($this->status == 'rejected') {
            return (new MailMessage)
                ->greeting('Welcome ' . $notifiable->name . ',')
                ->line("Unfortunately **Infancia's** team sending you this message to inform that your nursery registration with **Infancia** has been rejected.")
                ->line('Unfortunately, your application did not meet our criteria for acceptance. We encourage you to review the requirements and reapply in the future if possible.')
                ->line('If you have any questions or need further clarification, please do not hesitate to contact us:')
                ->line('**Email:** [info@infancia.com](mailto:info@infancia.com)')
                ->line('**Phone:** +202 22746241')
                ->line('---')
                ->salutation("Best regards, **Infancia's** Team");
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
