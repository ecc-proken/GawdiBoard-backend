<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Console\Commands\OfferDelete;
use \App\Console\Commands\PromotionDelete;
use \App\Console\Commands\SendDeleteEmail;
use \App\Console\Commands\UserDelete;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        OfferDelete::class,
        PromotionDelete::class,
        SendDeleteEmail::class,
        UserDelete::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // バッチ処理するコマンドをここに記述する
        // 毎日深夜0時掲載期間が終了した募集を削除
        $schedule->command('offer:delete')
            // 毎日深夜0時
            ->daily()
            // 環境(APP_ENV)がstagingかproductionの場合に実行
            ->environments(['staging', 'production'])
            // バックグラウンド実行
            ->runInBackground();

        // 毎日深夜0時掲載期間が終了した宣伝を削除
        $schedule->command('promotion:delete')
            ->daily()
            // 環境(APP_ENV)がstagingかproductionの場合に実行
            ->environments(['staging', 'production'])
            // バックグラウンド実行
            ->runInBackground();

        // 毎日11時に掲載終了3日前と当日の投稿主にメールを送信
        $schedule->command('send:delete-email')
            ->dailyAt('11:00')
            // 環境(APP_ENV)がstagingかproductionの場合に実行
            ->environments(['staging', 'production'])
            // バックグラウンド実行
            ->runInBackground();

        // 年度始め(4月1日)に7年経過ユーザーを削除
        $schedule->command('user:delete')
            ->yearlyOn(4, 1, '00:00')
            // 環境(APP_ENV)がstagingかproductionの場合に実行
            ->environments(['staging', 'production'])
            // バックグラウンド実行
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
