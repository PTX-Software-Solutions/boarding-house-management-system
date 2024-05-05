<?php

namespace App\Mail;

use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ManagementReservationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $reservation)
    {
        $this->user = $user;
        $this->reservation = $reservation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Management Reservation Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $roomDetail = Room::where('id', $this->reservation->roomId)
            ->select('name')
            ->first();

        return new Content(
            markdown: 'mail.management.reservation_notification',
            with: [
                'user' => $this->user,
                'reservation' => $this->reservation,
                'roomDetail'  => $roomDetail,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
