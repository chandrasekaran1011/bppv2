<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerRegistrationInitiated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use App\Models\Ethics\Audit;

class PartnerRegistrationInitiatedListener implements ShouldQueue
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
     * @param  PartnerRegistrationInitiated  $event
     * @return void
     */
    public function handle(PartnerRegistrationInitiated $event)
    {
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->cuser;
        $a->action="Partner Registration Initiated ";
        $a->save();
        
        $exe='python '.config('python_search_location','ethics.py').' '.$event->partner->id. ' "'.$event->partner->name.'"';
        exec($exe);

        Log::info('New  Partner Registration Initiated: '.$event->partner->name);


    }
}
