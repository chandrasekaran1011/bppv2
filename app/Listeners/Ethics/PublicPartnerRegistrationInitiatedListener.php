<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PublicPartnerRegistrationInitiated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use App\Models\Audit;
class PublicPartnerRegistrationInitiatedListener implements ShouldQueue
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
     * @param  PublicPartnerRegistrationInitiated  $event
     * @return void
     */
    public function handle(PublicPartnerRegistrationInitiated $event)
    {
        $exe='python ethics.py '.$event->partner->id. ' "'.$event->partner->name.'"';
        exec($exe);

        $a=new Audit;
            $a->partner_id=$event->partner->id;
            $a->user_id=$event->partner->cuser;
            $a->action="Registration Initiated";
        $a->save();

        Log::info('New Public Client Registration Initiated: '.$event->partner->name);
    }
}
