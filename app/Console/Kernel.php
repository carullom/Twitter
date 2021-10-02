<?php

namespace App\Console;

use App\Models\Post;
use Abraham\TwitterOAuth\TwitterOAuth;
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
       
        $schedule->call(function(){
            $data=now();
            $tweet=Post::where('schedule_at','=',$data)->where('pubblished_at',null)->value('tweet');
            $TWITTER_CONSUMER_KEY='xEO43oCVeUF4g3cq4Ht0LzcED';
            $TWITTER_CONSUMER_SECRET='8BKMJvLAmAY2dngGfyXYFvZ9O0dQh8pgwXf1myjYNYbwR1KzOU';
            $TWITTER_ACCESS_TOKEN='1443605675729432580-C1pzICwQinmgUUGzBFQh0LqQNyhfkr';
            $TWITTER_ACCESS_TOKEN_SECRET='KVyCBhctUzAI5S78HyDmyqyvrxCZf4t9k5vaLJbZupuRW';
            
    
            $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $TWITTER_ACCESS_TOKEN, $TWITTER_ACCESS_TOKEN_SECRET);
            $statues = $connection->post("statuses/update", ["status" => $tweet]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
