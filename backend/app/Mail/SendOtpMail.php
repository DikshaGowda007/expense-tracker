<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;

    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your OTP Code'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.send_otp',
            with: [
                'otp' => $this->otp
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Your OTP Code')
                    ->view('emails.send_otp')
                    ->with([
                        'otp' => $this->otp,
                    ]);
    }
}

