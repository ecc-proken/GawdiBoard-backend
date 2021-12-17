<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactManagement;

class SendContactManagementEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    #送信先アドレス
    public $to_email;

    #mailableクラスに送る情報
    public $info;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email, $info)
    {
        $this->to_email = $to_email;
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->to_email)->send(new ContactManagement($this->info));
    }
}
