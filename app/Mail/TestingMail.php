<?php

namespace App\Mail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Attachment;

class TestingMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   */
  public function __construct(protected $data)
  {
    //
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    return new Envelope(
      from: new Address('jeffreyway@example.com', 'Jeffrey Way'),
      subject: 'Testing Mail'
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'mails.testing',
      with: [
        'email' => $this->data['email'],
        'password' => $this->data['password'],
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
    return [
        // Attachment::fromPath(
        //   Storage::path('images/VG8Ol6iwytVUO9dWC7bit6jtOqNzmhrnYR9PwMSt.png')
        // )
        //   ->as('laracasts.jpg')
        //   ->withMime('application/jpg'),
      ];
  }
}
