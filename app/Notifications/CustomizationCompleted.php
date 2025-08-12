<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class CustomizationCompleted extends Notification
{
    use Queueable;

    protected $customization;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\CustomizationRequest $customization
     * @return void
     */
    public function __construct($customization)
    {
        $this->customization = $customization;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Email and in-app notification
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Customization is Complete')
            ->line('Your trophy customization request has been completed.')
            ->line('Please find the final image attached and view it in your cart.')
            ->action('View in Cart', url('/cart'))
            ->attach(storage_path('app/public/' . $this->customization->final_image), [
                'as' => 'final-image.jpg', // Filename for the attachment
                'mime' => 'image/jpeg',    // MIME type (adjust based on image type)
            ]);
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your customization request is complete. View it in your cart.',
            'url' => '/cart',
            'customization_id' => $this->customization->id,
            'created_at' => now(),
        ];
    }
}