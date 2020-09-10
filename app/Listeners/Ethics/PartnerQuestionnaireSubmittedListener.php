<?php

namespace App\Listeners\Ethics;

use App\Models\Ethics\Audit;
use App\Events\Ethics\PartnerQuestionnaireSubmitted;
use App\Models\Admin\User;
use App\Models\Ethics\Partner;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Notification;
use App\Notifications\ApprovalNotification;
use PDF;
use Illuminate\Support\Facades\Storage;

class PartnerQuestionnaireSubmittedListener implements ShouldQueue
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


        $u=User::where('id',$event->partner->cuser)->first();

        Notification::route('mail',$u->email)->notify(new ApprovalNotification($event->partner));

        Log::info('Partner Questionaire has been Submitted: '.$event->partner->name);

        $e = Partner::where('id',$event->partner->id)->with('ethics')->first();
       
        
        if($e){
            
            $name='questionnaire.pdf';
            if($e->type_id!=8){
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ethics.pdf.questionnaire',[
                    
                    'e'=>$e
                ]);
                
            }else{
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ethics.pdf.questionnaire-individual',[
                    
                    'e'=>$e
                ]);
            }

            $content = $pdf->download()->getOriginalContent();

           //$pdf->save(storage_path('app/myDisk/'.$e->uuid.'/questionnaire.pdf'));
            
            Storage::disk('myDisk')->put($e->uuid.'/questionnaire.pdf', $content);
        }            




    }
}
