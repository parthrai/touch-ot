<?php

namespace parthrai\twitter ;

use Phirehose;
use parthrai\twitter\TwitterStream;
use Illuminate\Support\ServiceProvider;

class twitterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    protected $commands = [
        \parthrai\twitter\Commands\ConnectToStreamingAPI::class,

    ];

    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->commands($this->commands);

        $this->app->bind('parthrai\twitter\TwitterStream', function ($app) {
            $twitter_access_token = env('TWITTER_ACCESS_TOKEN', null);
            $twitter_access_token_secret = env('TWITTER_ACCESS_TOKEN_SECRET', null);
            return new TwitterStream($twitter_access_token, $twitter_access_token_secret, Phirehose::METHOD_FILTER);
        });
    }
}
