<?php

namespace App\Mail;

use App\Helpers\AppHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $myinvoice;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $address;
    public $senderName;
    public $senderEmail;

    public function __construct($myinvoice, $firstName, $lastName, $email,$phone,$address,$senderName,$senderEmail)
    {
        $this->myinvoice = $myinvoice;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
    }

    public function build()
    {
        return $this
            ->subject('Sales Invoice From'.' '.AppHelper::site_name())
            ->view('emails.invoice_mail')
            ->with([
                'myinvoice' => $this->myinvoice,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
            ]);
    }
}
