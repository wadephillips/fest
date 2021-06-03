<?php

namespace App\Mail;

use App\Attendee;
use App\Event;
use App\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationSuccessful extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;
  /**
   * @var Attendee - The attendees who have been registered and paid for in this group of registrations
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
     * @param Event $event
     */
    public function __construct(array $attendees, Payment $payment, Event $event)
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

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->markdown('emails.registration.success');
    }
}
