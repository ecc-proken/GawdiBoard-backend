<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '作成から7年経ったユーザを削除する';

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
        // トランザクションの開始
        DB::transaction(function () {
            # 戻り値は削除件数
            $delete_users = user::whereDate('created_at', '>', date('Y-m-d', strtotime('-7 year')))->delete();
            $message = '[' . date('Y-m-d h:i:s') . '] ユーザー ： ' . $delete_users . '件削除';

            //INFOレベルでメッセージを出力
            $this->info($message);
            //ログを書き出す
            Log::setDefaultDriver('batch');
            Log::info($message);
        });
    }
}
