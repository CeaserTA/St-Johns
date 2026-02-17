<?php

namespace App\Mail;

use App\Models\ServiceRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceRegistrationReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct(ServiceRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build()
    {
        return $this->subject('Service Registration Confirmed - Receipt #' . $this->registration->receipt_number)
                    ->view('mails.service_registration_receipt');
    }
}
