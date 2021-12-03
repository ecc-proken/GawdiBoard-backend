<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OfferDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '掲載期間を過ぎた募集を削除する';

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
            $delete_offers = Offer::whereDate('end_date', '<', date('Y-m-d'))->delete();
            $message = '[' . date('Y-m-d h:i:s') . '] 募集 : ' . $delete_offers . '件削除';

            //INFOレベルでメッセージを出力
            $this->info($message);
            //ログを書き出す
            Log::setDefaultDriver('batch');
            Log::info($message);
        });
    }
}
