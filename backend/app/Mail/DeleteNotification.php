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
        # 掲載終了日と3日前でビューを分ける
        if ($this->info->end_date === date('Y-m-d')) {
            return $this->markdown('mail.deleted-notification')
                ->with([
                    'type' => $this->info->type,
                    'title' => $this->info->title,
                    'profile' => $this->info->profile,
                    'end_date' => $this->info->end_date,
                ])
                # 件名
                ->subject('掲載が終了しました - Gawdi Board');
        } elseif ($this->info->end_date === date('Y-m-d', strtotime('+3 day'))) {
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
}
