<?php

namespace App\Mail;

use App\Models\Giving;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class GivingReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $giving;

    public function __construct(Giving $giving)
    {
        $this->giving = $giving;
    }

    public function build()
    {
        return $this->subject('Thank You for Your Giving - Receipt #' . $this->giving->receipt_number)
                    ->view('mails.giving_receipt');
    }
}
