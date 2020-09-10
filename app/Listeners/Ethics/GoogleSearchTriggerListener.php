<?php

namespace App\Listeners\Ethics;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GoogleSearchTriggerListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $exe='python '.config('python_search_location','ethics.py').' '.$event->partner->id. ' "'.$event->partner->name.'"';
        exec($exe);
    }
}
