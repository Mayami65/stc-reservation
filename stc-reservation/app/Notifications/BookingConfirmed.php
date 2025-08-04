<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmed extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
        $trip = $this->booking->trip;
        $route = $trip->route;
        $seat = $this->booking->seat;

        return (new MailMessage)
            ->subject('Booking Confirmed - STC Bus Reservation')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your bus booking has been successfully confirmed.')
            ->line('**Booking Details:**')
            ->line('• **Booking ID:** ' . $this->booking->id)
            ->line('• **Route:** ' . $route->origin . ' → ' . $route->destination)
            ->line('• **Date:** ' . $trip->departure_date->format('l, F j, Y'))
            ->line('• **Time:** ' . $trip->departure_time)
            ->line('• **Seat Number:** ' . $seat->seat_number)
            ->line('• **Status:** ' . ucfirst($this->booking->status))
            ->line('• **Expires:** ' . ($this->booking->expires_at ? $this->booking->expires_at->format('l, F j, Y \a\t g:i A') : 'No expiry'))
            ->line('')
            ->line('**Important Information:**')
            ->line('• Please arrive at least 30 minutes before departure time')
            ->line('• Present your QR code ticket at the boarding gate')
            ->line('• Keep this email for your records')
            ->line('')
            ->action('View My Bookings', route('user.bookings'))
            ->line('Thank you for choosing STC Bus Reservation!')
            ->salutation('Best regards, STC Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'trip_id' => $this->booking->trip_id,
            'seat_id' => $this->booking->seat_id,
            'status' => $this->booking->status,
        ];
    }
}
