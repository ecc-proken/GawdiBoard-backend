<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferCompleted extends Mailable
{
    use Queueable, SerializesModels;
    public $owner;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.offer-completed')
            ->with([
                'student_number' => $this->owner->student_number,
                'user_name' => $this->owner->user_name,
                'title' => $this->owner->title,
                'email' => $this->owner->email,
            ])
            # 件名
            ->subject('募集主へ連絡が送信されました - Gawdi Board');
    }
}
