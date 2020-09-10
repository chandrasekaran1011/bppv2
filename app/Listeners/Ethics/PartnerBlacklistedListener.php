<?php

namespace App\Listeners\Ethics;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Log;

use App\Models\Ethics\Audit;

class PartnerBlacklistedListener implements ShouldQueue
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
     * @param  PartnerBlacklisted  $event
     * @return void
     */
    public function handle($event)
    {
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->blacklist_by;
        $a->action="Partner Blacklisted ";
        $a->save();

        Log::info('Partner Blacklisted: '.$event->partner->name);
    }
}
