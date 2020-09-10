<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PartnerRegisteredListener implements ShouldQueue
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
     * @param  PartnerRegistered  $event
     * @return void
     */
    public function handle(PartnerRegistered $event)
    {
        
        Log::info('Partner Registration Notification');
    }
}
