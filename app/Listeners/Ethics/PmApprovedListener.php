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
use App\Models\Ethics\Partner;
use App\Notifications\FinanceNotification;
use PDF;
use Illuminate\Support\Facades\Storage;

class PmApprovedListener implements ShouldQueue
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

        $user=User::where('id',$event->partner->ethics->ims_assign)->first();
        if($user){
            Notification::route('mail',$user->email)->notify(new ApprovalNotification($event->partner));
        } 

        Log::info('PM/Bid Manager Approved: '.$event->partner->name);
        Log::info('Financial approver is'.$event->partner->ethics->finance_assigned);
        if($event->partner->ethics->finance_assigned!=null){
            $fin=User::where('id',$event->partner->ethics->finance_assigned)->first();
            Notification::route('mail',$fin->email)->notify(new  FinanceNotification($event->partner));
        
        }

        if(config('ethics.accounts_notification')){
            Notification::route('mail','tresorerie@systra.com')->notify(new  FinanceNotification($event->partner));
        }

        $e = Partner::where('id',$event->partner->id)->with('ethics')->first();

        if($e){
            
            $name='BP Form.pdf';
            $pdf = PDF::loadView('ethics.pdf.partnerForm',[
                'e'=>$e
            ]);

            $content = $pdf->download()->getOriginalContent();

           //$pdf->save(storage_path('app/myDisk/'.$e->uuid.'/questionnaire.pdf'));
            
            Storage::disk('myDisk')->put($e->uuid.'/BPForm.pdf', $content);
        }     

        

    }
}
