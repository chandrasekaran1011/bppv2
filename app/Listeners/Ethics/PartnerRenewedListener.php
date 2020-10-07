<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerRenewed;
use App\Models\Admin\User;
use App\Models\Ethics\Audit;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use App\Models\Ethics\Partner;
use PDF;
use Illuminate\Support\Facades\Storage;




class PartnerRenewedListener implements ShouldQueue
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
     * @param  PartnerRenewed  $event
     * @return void
     */
    public function handle(PartnerRenewed $event)
    {
        $a=new Audit;
        $a->partner_id=$event->partner->id;
        $a->user_id=$event->partner->ethics->renew_ims_by;
        $a->action="Partner Renewal Approved ";
        $a->save();

        Log::info('Partner Renewal Approved: '.$event->partner->name);

        $e = Partner::where('id',$event->partner->id)->with('ethics')->first();
       
        
        if($e){
            
            $name='renwewal.pdf';
            
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ethics.pdf.renewForm',[
                    
                    'e'=>$e
                ]);
                
           
            $content = $pdf->download()->getOriginalContent();

           //$pdf->save(storage_path('app/myDisk/'.$e->uuid.'/questionnaire.pdf'));
            
            Storage::disk('myDisk')->put($e->uuid.'/renewal.pdf', $content);
        } 

    }
}
