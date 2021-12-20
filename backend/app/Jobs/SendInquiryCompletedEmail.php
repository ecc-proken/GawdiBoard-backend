<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryCompleted;

class SendInquiryCompletedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    #送信先アドレス
    public $to_email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email)
    {
        $this->to_email = $to_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to_email)->send(new InquiryCompleted());
    }
}
