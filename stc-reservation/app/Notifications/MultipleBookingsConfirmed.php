<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use App\Models\Trip;

class MultipleBookingsConfirmed extends Notification
{
    use Queueable;

    protected $bookings;
    protected $trip;

    /**
     * Create a new notification instance.
     * @param Collection $bookings
     * @param Trip $trip
     */
    public function __construct($bookings, Trip $trip)
    {
        $this->bookings = $bookings;
        $this->trip = $trip;
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
        $mail = (new MailMessage)
            ->subject('Multiple Bookings Confirmed - STC Bus Reservation')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your multiple seat bookings have been successfully confirmed.')
            ->line('**Trip Details:**')
            ->line('• **Route:** ' . $this->trip->route->origin . ' → ' . $this->trip->route->destination)
            ->line('• **Date:** ' . $this->trip->departure_date->format('l, F j, Y'))
            ->line('• **Time:** ' . $this->trip->departure_time)
            ->line('• **Bus:** ' . $this->trip->bus->name)
            ->line('')
            ->line('**Your Bookings:**');

        foreach ($this->bookings as $booking) {
            $mail->line('— Seat: ' . $booking->seat->seat_number . ' | Booking ID: #' . $booking->id . ' | Status: ' . ucfirst($booking->status));
            if ($booking->qr_code_path) {
                $mail->line('   [Download QR Code](' . asset('storage/' . $booking->qr_code_path) . ') | [View Details](' . route('bookings.show', $booking) . ')');
            }
        }

        $mail->line('')
            ->line('**Important Information:**')
            ->line('• Each passenger needs their own QR code for boarding verification')
            ->line('• Arrive at the terminal at least 30 minutes before departure')
            ->line('• Keep all QR codes safe until your journey is complete')
            ->line('• Contact support if you need to make changes to your bookings')
            ->action('View All My Bookings', route('user.bookings'))
            ->line('Thank you for choosing STC Bus Reservation!')
            ->salutation('Best regards, STC Team');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_ids' => $this->bookings->pluck('id'),
            'trip_id' => $this->trip->id,
        ];
    }
}
