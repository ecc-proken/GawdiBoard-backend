<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;
use App\Models\User;
use App\Models\Promotion;
use App\Jobs\SendDeleteNotification;

class SendDeleteEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:delete-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '掲載終了日より3日目の投稿のユーザーにメールを送信';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        # 掲載終了３日前の募集を一覧取得
        $fetched_offers = Offer::whereDate('end_date', '=', date('Y-m-d', strtotime('+3 day')))
            ->get();

        # 掲載終了３日前の宣伝を一覧取得
        $fetched_promotions = Promotion::with(['users', ])
            ->whereDate('end_date', '=', date('Y-m-d', strtotime('+3 day')))
            ->get();

        $this->send_email($fetched_offers, '募集');
        $this->send_email($fetched_promotions, '宣伝');
    }

    # send_email(DBから取ってきたコレクション, "募集" or "宣伝")
    private function send_email($fetched_data, $type)
    {
        foreach ($fetched_data as $data) {
            #ユーザープロフィールのリンクとメールアドレスを取得
            $user = User::findOrFail($data->student_number);
            $profile_link = $user->getUserProfileLink();
            $to_email = $user->email;

            # メール送信に必要なオブジェクトを構成
            $mail_info = (object) [];
            $mail_info = (object) [
                'type' => $type,
                'title' => $data->title,
                'profile' => $profile_link,
                'end_date' => $data->end_date,
            ];

            #メール送信をキューに格納 (送信先, メール情報)
            SendDeleteNotification::dispatch($to_email, $mail_info);
        }
    }
}
