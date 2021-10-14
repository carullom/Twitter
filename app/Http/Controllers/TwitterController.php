<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tweet;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Log;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Validator;

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
        
        $rules = array(
            'tweet' => ['required','max:240'],

        );

        $code = array(
            'tweet.required' => 0,
            'tweet.max' => 1,

        );

        $credentials = Validator::make($request->all(), $rules, $code);

        if ($credentials->fails()) {

            $errors = $this->validation($credentials);
            return response()->json(['errors' => $errors], 422);
        }
      
        $tweet=$request->input('tweet');
        $statues = $connection->post("statuses/update", ["status" => $tweet]);
        Log::info('request', $request->all());
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
    //funzione per programmare i tweet
    public function schedule(Request $request){
        $rules = array(
            'tweet' => ['required','max:240'],

        );

        $code = array(
            'tweet.required' => 0,
            'tweet.max' => 1,

        );

        $credentials = Validator::make($request->all(), $rules, $code);

        if ($credentials->fails()) {

            $errors = $this->validation($credentials);
            return response()->json(['errors' => $errors], 422);
        }
        $now=now();
        $tweet=$request->input('tweet');
        $schedule_at=$request->input('schedule_at');
        $post=new Post();
        $post->tweet=$tweet;
        $post->schedule_at=$schedule_at;
        if($schedule_at<$now){
            Log::info('request', $request->all());
            return response()->json("impossibile programmare il post",400);
        }else{
            Log::info('request', $request->all());
            $post->save();
            return $post;
            //in app/console/kernel.php è presente lo scheduling che ogni minuto controlla se ci sono post da pubblicare tramite la colonna "schedule_at"
        }
      
        
    }
    //funzione per visualizzare i tweet programmati e non ancora pubblicati
    public function schedulePost(){
        $post=Post::where('pubblished_at', null)->orderBy('schedule_at')->get();
        return $post;
    }

    //funzione per recuperare dati utente 
    public function user(){
      
        $connection = new TwitterOAuth($this->TWITTER_CONSUMER_KEY, $this->TWITTER_CONSUMER_SECRET, $this->TWITTER_ACCESS_TOKEN, $this->TWITTER_ACCESS_TOKEN_SECRET);
        $statuses = $connection->get("account/verify_credentials");
        return $statuses;
    }





    protected function validation($credentials)
    {
        $myerror = [];
        $myerror['0'] = "Il testo è richiesto";
        $myerror['1'] = "Il testo può contenere max 240 caratteri";
       


        $errors = [];
        foreach ($credentials->errors()->all() as $key) {
            $errors['message'] = $myerror[$key];
            break;
        }
        return $errors;
    }

}
