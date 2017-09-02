<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\UserActivation;
use App\Mail;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $aktivasi;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserActivation $aktivasi)
    {
        $this->aktivasi = $aktivasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('novelbaru@administrator.com')
                ->markdown('emails.activation');
    }
}
