<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.delete-notification')
            ->with([
                'type' => $this->info->type,
                'title' => $this->info->title,
                'profile' => $this->info->profile,
                'end_date' => $this->info->end_date,
            ])
            # 件名
            ->subject('もうすぐ掲載が終了します - Gawdi Board');
    }
}
