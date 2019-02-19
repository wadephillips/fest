<?php

namespace App\Mail;

use App\Attendee;
use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationSuccessful extends Mailable
{
    use Queueable, SerializesModels;
  /**
   * @var Attendees - The attendees who have been registered and paid for in this group of registrations
   */
  private $attendees;
  /**
   * @var Payment - the Payment for the group of registrations
   */
  private $payment;

  /**
   * Create a new message instance.
   *
   * @param array $attendees
   * @param Payment $payment
   */
    public function __construct(array $attendees, Payment $payment)
    {

      $this->attendees = $attendees;
      $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.registration.success');
    }
}
