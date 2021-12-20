<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferApply extends Mailable
{
    use Queueable, SerializesModels;
    public $apply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apply)
    {
        $this->apply = $apply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        # 現段階ではマークダウン記法で作成
        return $this->markdown('mail.offer-apply')
            ->with([
                'student_number' => $this->apply->student_number,
                'user_name' => $this->apply->user_name,
                'title' => $this->apply->title,
                'profile' => $this->apply->profile,
                'email' => $this->apply->email,
                'interest' => $this->apply->interest,
                'message' => $this->apply->message,
            ])
            # 件名
            ->subject($this->subjectDecision($this->apply->interest));
    }

    # 興味度から件名を判断
    private function subjectDecision($interest)
    {
        if ($interest == 1) {
            return 'あなたの募集に参加希望の人がいます - Gawdi Board';
        } elseif ($interest == 2) {
            return 'あなたの募集に興味がある人がいます - Gawdi Board';
        } elseif ($interest == 3) {
            return 'あなたの募集について話を聞いてみたい人がいます - Gawdi Board';
        }
    }
}
