<?php

namespace App\Jobs\Ethics;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Events\Ethics\PmApproved;
use App\Models\Admin\User;

use Illuminate\Support\Facades\Log;
use App\Models\Ethics\Partner;
use PDF;
use Illuminate\Support\Facades\Storage;

class createPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $e = Partner::where('id',$this->id)->with('ethics')->first();

        if($e->status>3 && $e->type_id!=1){
            
            $name='BP Form.pdf';
            $pdf = PDF::loadView('ethics.pdf.partnerForm',[
                'e'=>$e
            ]);

            $content = $pdf->download()->getOriginalContent();

           //$pdf->save(storage_path('app/myDisk/'.$e->uuid.'/questionnaire.pdf'));
            
            Storage::disk('myDisk')->put($e->uuid.'/BPForm.pdf', $content);
        }
        if($e->status>2 && $e->type_id!=1){
            
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

        if($e->status>3 && $e->type_id==1){
            $name='BP Form.pdf';
            $pdf = PDF::loadView('ethics.pdf.publicPartnerForm',[
                'e'=>$e
            ]);

            $content = $pdf->download()->getOriginalContent();

           //$pdf->save(storage_path('app/myDisk/'.$e->uuid.'/questionnaire.pdf'));
            
            Storage::disk('myDisk')->put($e->uuid.'/BPForm.pdf', $content);
        }

    }
}
