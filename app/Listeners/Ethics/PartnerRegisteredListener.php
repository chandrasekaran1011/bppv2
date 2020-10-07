<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerRegistered;
use App\Jobs\Ethics\createPDF;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Ethics\PartnerRegistrationComplete;
use App\Models\Admin\User;

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
        createPDF::dispatch($event->partner->id);
        

        $cuser=User::where('id',$event->partner->cuser)->first();
        $when=now()->addMinutes(5);
        Mail::to($cuser)->later($when,new PartnerRegistrationComplete($event->partner));
    }
}
