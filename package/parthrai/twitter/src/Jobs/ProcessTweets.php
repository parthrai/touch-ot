<?php

namespace parthrai\twitter\Jobs;

//use App\Jobs;

use App\Events\TwitterUpdated;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class ProcessTweets implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $tweet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tweet = json_decode($this->tweet,true);

        print_r( $tweet);


        $data=array(
            'tweet_id'=> $tweet['id_str'],
            'tweet_text' => $tweet['text'],
            'user_id' => $tweet['user']['id_str'],
            'screen_name' => $tweet['user']['screen_name'],
            'name' => $tweet['user']['name'],
            'profile_image_url' => $tweet['user']['profile_image_url'],
            'tags'=>$tweet['entities']['hashtags'],
            'is_approved'=>false,
            'timestamp'=>$tweet['timestamp_ms'],



        );


        echo "************************";
        echo "*************************************************************** FIRST THING*******************88";

        echo "time stamp ====" . $tweet['timestamp_ms'];
       echo "%%%%%%%%%%%%%%%%%%%%%%%%%%%%";

        $tweet_data=array(
            'tweet_id'=>$tweet['id_str'],
            'tweet_text'=>$tweet['text'],
            'geo_lat'=>0.00,
            'geo_long'=>0.00,
            'user_id'=>$tweet['user']['id'],
            'screen_name'=>$tweet['user']['screen_name'],
            'name'=>$tweet['user']['name'],
            'profile_image_url'=>$tweet['user']['profile_image_url'],
            'is_rt'=>$tweet['retweeted'],
            'is_approved' => false,
        );

       $ch =  DB::table('tweets')->insert($tweet_data);



       if(isset($tweet['entities']['media'])){
           $media=array(
               'tweet_id'=>$tweet['id_str'],
               'media'=>$tweet['entities']['media'][0]['media_url']
           );

           $data['media']=$tweet['entities']['media'][0]['media_url'];
           $tweet['media_img']=$tweet['entities']['media'][0]['media_url'];
           DB::table('tweet_media')->insert($media);

       }

      //  echo "tweets added <br>";

       // echo "************************   ".$ch. "    ^^^^^^^^";


        print_r ($tweet['entities']['hashtags']);

        if(sizeof($tweet['entities']['user_mentions']) > 0 );
        {
            foreach($tweet['entities']['user_mentions'] as $user_m){

               DB::table('tweet_mentions')->insert(['tweet_id'=>$tweet['id'],'source_user_id'=>$tweet['user']['id'],

                   'target_user_id'=>$user_m['id']]);

             //   echo "mentioens added <br>";

            }
        }

        if(sizeof($tweet['entities']['hashtags']) > 0 );
        {
            foreach($tweet['entities']['hashtags'] as $hashtag){

                DB::table('tweet_tags')->insert(['tweet_id'=>$tweet['id_str'],'tag'=>$hashtag['text']]);


                echo "tags added <br>";

            }
        }

        if(sizeof($tweet['entities']['urls']) > 0 );
        {
            foreach($tweet['entities']['urls'] as $url){

                DB::table('tweet_urls')->insert(['tweet_id'=>$tweet['id_str'],'url'=>$url['expanded_url']]);

                echo "urls added <br>";
            }
        }



        Redis::set('tweet:'.$tweet['id_str'],json_encode($data) );

        event(new TwitterUpdated($tweet));

        curl_exec(curl_init('http://beats.envoyer.io/heartbeat/Cq5WVE6fjITwIU7'));


    }
}