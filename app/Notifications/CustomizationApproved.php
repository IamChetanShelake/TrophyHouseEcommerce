<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomizationApproved extends Notification
{
    use Queueable;

    protected $customization;

    public function __construct($customization)
    {
        $this->customization = $customization;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Customization Approved')
            ->line('The user has approved the customization request.')
            ->action('View Details', url('/customization/workspace/' . $this->customization->id));
    }
}