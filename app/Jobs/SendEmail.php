<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($book, $template)
    {
        $this->book = $book;
        $this->template = $template;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
          Mail::send('mail', $book, function($message) use ($book) {
            $user = $book->user;
            if($user && $user->email){
              $message->to($user->email, 'Library Management')->subject
                 ('Notification of overdue books');
              $message->from('xyz@gmail.com','Virat Gandhi');
            }
         });
         echo "HTML Email Sent. Check your inbox.";
        } catch (\Exception $e) {
          \Log::error('[ERROR_SEND_MAIL]: ' . $e->getMessage());
        }
    }
}
