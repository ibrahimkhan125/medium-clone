<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Jobs\NewPostMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyFollowers
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticlePublished $event): void
    {
        NewPostMail::dispatch($event->post);
    }
}
