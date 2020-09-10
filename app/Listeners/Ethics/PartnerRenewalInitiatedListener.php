<?php

namespace App\Listeners\Ethics;

use App\Models\Admin\User;
use App\Models\Ethics\Audit;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ApprovalNotification;

class PartnerRenewalInitiatedListener implements ShouldQueue
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
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->ethics->renew_pm_by;
        $a->action="Partner Renewal Initiated ";
        $a->save();

             

        $user=User::where('id',$event->partner->renew_assign)->first();
        if($user){
            Notification::route('mail',$user->email)->notify(new ApprovalNotification($event->partner));
        }    

        Log::info('Partner Renewal Initiated: '.$event->partner->name);
    }
}
