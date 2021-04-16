<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class DeadlineNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $books;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $books)
    {
      $this->user = $user;
      $this->books = $books;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject('Notification of overdue books')
                    ->view('admin.mail.deadline');
    }
}
