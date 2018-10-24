<?php

namespace parthrai\twitter;

use OauthPhirehose;
use parthrai\twitter\Jobs\ProcessTweets;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TwitterStream extends OauthPhirehose
{
    use DispatchesJobs;

    /**
     * Enqueue each status
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        $this->dispatch(new ProcessTweets($status));
    }
}