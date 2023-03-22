<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyReferees extends Mailable
{
    use Queueable, SerializesModels;
    public $maildata;
    public $sub;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata, $sub)
    {
        $this->maildata = $maildata;
        $this->sub = $sub;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->sub)->markdown('backend.emails.notify-referees');
    }
}
