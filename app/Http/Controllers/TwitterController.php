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
    private $TWITTER_CONSUMER_KEY;
    private $TWITTER_CONSUMER_SECRET;
    private $TWITTER_ACCESS_TOKEN;
    private $TWITTER_ACCESS_TOKEN_SECRET;

    public function __construct()
    {
         $this->TWITTER_CONSUMER_KEY=env('TWITTER_CONSUMER_KEY');
         $this->TWITTER_CONSUMER_SECRET=env('TWITTER_CONSUMER_SECRET');
         $this->TWITTER_ACCESS_TOKEN=env('TWITTER_ACCESS_TOKEN');
         $this->TWITTER_ACCESS_TOKEN_SECRET=env('TWITTER_ACCESS_TOKEN_SECRET');


    }
    //funzione per pubblicare un tweet
    public function insert(Request $request){
        $connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET, $this->TWITTER_ACCESS_TOKEN, $this->TWITTER_ACCESS_TOKEN_SECRET);
        $tweet=$request->input('tweet');
        $statues = $connection->post("statuses/update", ["status" => $tweet]);
        return $statues;
      
    }
    //funzione per richimare la pagina della web app
    public function twitter(){
        return view('twitter');
    }
    //funzione per visualizzare i tweet pubblicati
    public function tweet(){
      
        $connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET, $this->TWITTER_ACCESS_TOKEN, $this->TWITTER_ACCESS_TOKEN_SECRET);
        $statuses = $connection->get("statuses/user_timeline");
        return $statuses;
    }
    //funzione per progtammare i tweet
    public function schedule(Request $request){
        $tweet=$request->input('tweet');
        $schedule_at=$request->input('schedule_at');
        $post=new Post();
        $post->tweet=$tweet;
        $post->schedule_at=$schedule_at;
        $post->save();
        return $post;
        
    }
    //funzione per visualizzare i tweet programmati e non ancora pubblicati
    public function schedulePost(){
        $post=Post::where('pubblished_at', null)->get();
        return $post;
    }

    //funzione per recuperare dati utente 
    public function user(){
      
        $connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET, $this->TWITTER_ACCESS_TOKEN, $this->TWITTER_ACCESS_TOKEN_SECRET);
        $statuses = $connection->get("account/verify_credentials");
        return $statuses;
    }

}
