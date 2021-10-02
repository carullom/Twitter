<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

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
}
