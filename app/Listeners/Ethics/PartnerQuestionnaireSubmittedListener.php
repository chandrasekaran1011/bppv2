<?php

namespace App\Listeners\Ethics;

use App\Models\Ethics\Audit;
use App\Events\Ethics\PartnerQuestionnaireSubmitted;
use App\Models\Admin\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Notification;
use App\Notifications\ApprovalNotification;


class PartnerQuestionnaireSubmittedListener
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
     * @param  PartnerQuestionnaireSubmitted  $event
     * @return void
     */
    public function handle(PartnerQuestionnaireSubmitted $event)
    {
        
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->action="Questionnaire Submitted ";
        $a->save();


        $u=User::find($event->partner->cuser)->first();

        Notification::route('mail',$u->email)->notify(new ApprovalNotification($event->partner));

        Log::info('Partner Questionaire has been Submitted: '.$event->partner->name);



    }
}
