<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mailData;
    public $btn_approve;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $btn_approve)
    {
        $this->mailData = $mailData;
        $this->btn_approve = $btn_approve;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $data = $this->mailData;
        $btn_approve = $this->btn_approve;

        $fromAddress = env('MAIL_FROM_ADDRESS');
        $fromName = env('MAIL_FROM_NAME');

        if (isset($data["type"]) && $data["type"] === 'expense') {
            $fromName = env('MAIL_FROM_NAME_2');
            return $this->from($fromAddress, $fromName)
                        ->subject('Expense Alert')
                        ->view('mail.mail-text-expense', [
                            'data' => $data,
                            'btn_approve' => $btn_approve
                        ]);
        } elseif (isset($data["type"]) && $data["type"] === 'kpi') {
            return $this->from($fromAddress, $fromName)
                        ->subject('KPI/PA Alert')
                        ->view('mail.mail-text-pa', [
                            'data' => $data,
                        ]);
        } else {
            return $this->from($fromAddress, $fromName)
                        ->subject('General Alert')
                        ->view('mail.mail-text', [
                            'data' => $data,
                            'btn_approve' => $btn_approve
                        ]);
        }
    }
}
