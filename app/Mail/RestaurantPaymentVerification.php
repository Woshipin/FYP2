<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BookingRestaurant;

class RestaurantPaymentVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $VerifyRestaurant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BookingRestaurant $VerifyRestaurant)
    {
        $this->VerifyRestaurant = $VerifyRestaurant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Restaurant Payment Verification')
                    ->view('email.verifyrestaurant');
    }
}
