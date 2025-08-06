<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $mailData;
    public $btn_approve;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $btn_approve)
    {
        $this->mailData = $mailData;
        $this->btn_approve = $btn_approve;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->mailData;
        $btn_approve = $this->btn_approve;
        if (isset($this->mailData["type"]) && $this->mailData["type"] === 'expense') {
            $fromAddress = env('MAIL_FROM_ADDRESS');
            $fromName = env('MAIL_FROM_NAME_2');

            return $this->from($fromAddress, $fromName)
                        ->subject('Expense Alert')
                        ->view('mail.mail-text-expense', [
                            'data' => $data,
                            'btn_approve' => $btn_approve
                        ]);
        } else {
            $fromAddress = env('MAIL_FROM_ADDRESS');
            $fromName = env('MAIL_FROM_NAME');

            return $this->from($fromAddress, $fromName)
                        ->subject('General Alert')
                        ->view('mail.mail-text', [
                            'data' => $data,
                            'btn_approve' => $btn_approve
                        ]);
        }
    }
}
