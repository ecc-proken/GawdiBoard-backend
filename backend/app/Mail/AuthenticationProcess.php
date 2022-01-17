<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthenticationProcess extends Mailable
{
    use Queueable, SerializesModels;
    public $auth;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.authentication-process')
            ->with([
                'email' => $this->auth->email,
                'link' => $this->auth->link,
            ])
            # 件名
            ->subject('メールを確認してください - Gawdi Board');
    }
}
