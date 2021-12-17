<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.inquiry-completed')
            # 件名
            ->subject('お問い合わせありがとうございます - Gawdi Board');
    }
}
