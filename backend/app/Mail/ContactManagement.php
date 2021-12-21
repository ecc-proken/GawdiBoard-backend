<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactManagement extends Mailable
{
    use Queueable, SerializesModels;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.contact-management')
            ->with([
                'student_number' => $this->contact->student_number,
                'user_name' => $this->contact->user_name,
                'email' => $this->contact->email,
                'contact_type' => $this->contact->contact_type,
                'content' => $this->contact->content,
            ])
            # 件名
            ->subject($this->contact->admin_email . 'お問い合わせがあります - Gawdi Board');
    }
}
