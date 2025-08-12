<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EditRequested extends Notification
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
            ->subject('Edit Requested for Customization')
            ->line('The user has requested edits for a customization.')
            ->line('Feedback: ' . $this->customization->user_feedback)
            ->action('View Workspace', url('/customization/workspace/' . $this->customization->id));
    }
}