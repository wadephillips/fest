<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationError extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * @var string
     */
    public $where;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [], $where = ' an unspecified location')
    {
        $this->data = $data;
        $this->where = $where;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.registration.error');
    }
}
