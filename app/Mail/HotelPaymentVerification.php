<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\BookingHotel;

class HotelPaymentVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $VerifyHotel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BookingHotel $VerifyHotel)
    {
        $this->VerifyHotel = $VerifyHotel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hotel Payment Verification')
                    ->view('email.verifyhotel');
    }
}
