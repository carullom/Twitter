<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tweet;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterController extends Controller
{

 


    public function index(Request $request){
        $TWITTER_CONSUMER_KEY=env('TWITTER_CONSUMER_KEY');
        $TWITTER_CONSUMER_SECRET=env('TWITTER_CONSUMER_SECRET');
        $TWITTER_ACCESS_TOKEN=env('TWITTER_ACCESS_TOKEN');
        $TWITTER_ACCESS_TOKEN_SECRET=env('TWITTER_ACCESS_TOKEN_SECRET');

        $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, $TWITTER_CONSUMER_SECRET, $TWITTER_ACCESS_TOKEN, $TWITTER_ACCESS_TOKEN_SECRET);
        $tweet=$request->input('tweet');
        $statues = $connection->post("statuses/update", ["status" => $tweet]);
        return $statues;
      
    }

    public function twitter(){
        return view('twitter');
    }

    public function tweet(){
        $TWITTER_CONSUMER_KEY=env('TWITTER_CONSUMER_KEY');
        $TWITTER_CONSUMER_SECRET=env('TWITTER_CONSUMER_SECRET');
        $TWITTER_ACCESS_TOKEN=env('TWITTER_ACCESS_TOKEN');
        $TWITTER_ACCESS_TOKEN_SECRET=env('TWITTER_ACCESS_TOKEN_SECRET');
    

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

    public function schedulePost(){
        $post=Post::where('pubblished_at', null)->get();
        return $post;
    }

}
