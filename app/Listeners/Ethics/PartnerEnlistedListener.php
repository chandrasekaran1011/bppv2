<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerEnlisted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Audit;

class PartnerEnlistedListener implements ShouldQueue
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
     * @param  PartnerEnlisted  $event
     * @return void
     */
    public function handle(PartnerEnlisted $event)
    {
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->approved_by;
        $a->action="Partner Enlisted ";
        $a->save();

        Log::info('Partner Enlisted: '.$event->partner->name);
    }
}
