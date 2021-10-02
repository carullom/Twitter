<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Post;
use App\Models\Tweet;
use GuzzleHttp\Promise\Create;

class TwitterController extends Controller
{
    public function index(Request $request){
        $TWITTER_CONSUMER_KEY='xEO43oCVeUF4g3cq4Ht0LzcED';
        $TWITTER_CONSUMER_SECRET='8BKMJvLAmAY2dngGfyXYFvZ9O0dQh8pgwXf1myjYNYbwR1KzOU';
        $TWITTER_ACCESS_TOKEN='1443605675729432580-C1pzICwQinmgUUGzBFQh0LqQNyhfkr';
        $TWITTER_ACCESS_TOKEN_SECRET='KVyCBhctUzAI5S78HyDmyqyvrxCZf4t9k5vaLJbZupuRW';

        $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $TWITTER_ACCESS_TOKEN, $TWITTER_ACCESS_TOKEN_SECRET);
        $tweet=$request->input('tweet');
        $statues = $connection->post("statuses/update", ["status" => $tweet]);
        return $statues;
      
    }

    public function twitter(){
        return view('twitter');
    }

    public function tweet(){
        $TWITTER_CONSUMER_KEY='xEO43oCVeUF4g3cq4Ht0LzcED';
        $TWITTER_CONSUMER_SECRET='8BKMJvLAmAY2dngGfyXYFvZ9O0dQh8pgwXf1myjYNYbwR1KzOU';
        $TWITTER_ACCESS_TOKEN='1443605675729432580-C1pzICwQinmgUUGzBFQh0LqQNyhfkr';
        $TWITTER_ACCESS_TOKEN_SECRET='KVyCBhctUzAI5S78HyDmyqyvrxCZf4t9k5vaLJbZupuRW';

        $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $TWITTER_ACCESS_TOKEN, $TWITTER_ACCESS_TOKEN_SECRET);
        $statuses = $connection->get("statuses/user_timeline");
        return $statuses;
    }

    public function schedule(Request $request){
        $tweet=$request->input('tweet');
        $schedule_at=$request->input('schedule_at');
        $post=new Post();
        $post->tweet=$tweet;
        $post->schedule_at=$schedule_at;
        $post->save();
        return $post;
        
    }

}
