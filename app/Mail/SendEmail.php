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
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'HRMS Email',
        );
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
        return $this->view('mail.mail-text',['data'=>$data, 'btn_approve'=>$btn_approve]);
    }

    // /**
    //  * Get the message content definition.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Content
    //  */
    // public function content()
    // {
    //     return new Content(
    //         view: 'mail.mail-text',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array
    //  */
    // public function attachments()
    // {
    //     return [];
    // }
}
