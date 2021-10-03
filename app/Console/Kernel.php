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
            $tweets=Post::where('schedule_at','=',$data)->where('pubblished_at',null)->get();
            $TWITTER_CONSUMER_KEY=env('TWITTER_CONSUMER_KEY');
            $TWITTER_CONSUMER_SECRET=env('TWITTER_CONSUMER_SECRET');
            $TWITTER_ACCESS_TOKEN=env('TWITTER_ACCESS_TOKEN');
            $TWITTER_ACCESS_TOKEN_SECRET=env('TWITTER_ACCESS_TOKEN_SECRET');
            
    
            $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $TWITTER_ACCESS_TOKEN, $TWITTER_ACCESS_TOKEN_SECRET);
            foreach($tweets as $tweet){
                $statues = $connection->post("statuses/update", ["status" => $tweet['tweet']]);
            }
           
            $post=Post::where('schedule_at','=',$data)->where('pubblished_at',null)->update(['pubblished_at'=>$data]);
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
