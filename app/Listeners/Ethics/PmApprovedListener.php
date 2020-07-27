<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PmApproved;
use App\Models\Admin\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Notification;
use App\Notifications\ApprovalNotification;
use App\Models\Ethics\Audit;

class PmApprovedListener
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
     * @param  PmApproved  $event
     * @return void
     */
    public function handle(PmApproved $event)
    {

        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->ethics->pm_by;
        $a->action="Approved by BID / Project Manager";
        $a->save();

        $user=User::find($event->partner->ethics->ims_assign)->first();

        Log::info('PM/Bid Manager Approved: '.$event->partner->name);

        Notification::route('mail',$user->email)->notify(new ApprovalNotification($event->partner));

    }
}
