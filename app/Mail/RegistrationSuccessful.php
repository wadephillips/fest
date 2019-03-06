<?php

namespace App\Mail;

//use App\Attendee;
//use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;

class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;
  /**
   * @var Attendees - The attendees who have been registered and paid for in this group of registrations
   */
  public $attendees;
  /**
   * @var Payment - the Payment for the group of registrations
   */
  public $payment;

  /**
   * @var Event - the Event for the registrations and payment
   */
  public $event;

  /**
   * Create a new message instance.
   *
   * @param array $attendees
   * @param Payment $payment
   */
    public function __construct($attendees, $payment, $event)
    {

      $this->attendees = $attendees;
      $this->payment = $payment;
      $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        //todo resume: polish up the table to use new good info in the middle column, and add event info
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->markdown('emails.registration.success');
    }
}
