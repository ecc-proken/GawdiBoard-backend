<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Promotion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PromotionDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promotion:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '掲載期間が過ぎた宣伝を削除する';

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
            $delete_promotions = Promotion::whereDate('end_date', '<', date('Y-m-d'))->delete();
            $message = '[' . date('Y-m-d h:i:s') . '] 宣伝：' . $delete_promotions . '件削除';

            //INFOレベルでメッセージを出力
            $this->info($message);
            //ログを書き出す
            Log::setDefaultDriver('batch');
            Log::info($message);
        });
    }
}
