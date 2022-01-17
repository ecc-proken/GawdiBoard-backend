<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
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
        // 毎日深夜0時に掲載期間が終了した募集と宣伝を削除
        $schedule->command('offer:delete')->daily();
        $schedule->command('promotion:delete')->daily();
        // 毎日11時に掲載終了3日前の投稿主にメールを送信
        $schedule->command('send:delete-email')->dailyAt('11:00');
        // 年度始め(4月1日)に7年経過ユーザーを削除
        $schedule->command('user:delete')->yearlyOn(4, 1, '00:00');
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
