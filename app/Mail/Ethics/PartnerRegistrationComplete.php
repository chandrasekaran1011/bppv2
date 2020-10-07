<?php

namespace App\Mail\Ethics;

use App\Models\Ethics\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerRegistrationComplete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $partner;

     
    public function __construct(Partner $partner)
    {
        $this->partner=$partner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->partner->type_id!=1){
            return $this->view('ethics.mails.partnerRegistered')->with(['p'=>$this->partner])
            ->attachFromStorageDisk('myDisk', $this->partner->uuid.'/BPForm.pdf','Business partner Form.pdf', [
                'mime' => 'application/pdf'
            ])->attachFromStorageDisk('myDisk', $this->partner->uuid.'/questionnaire.pdf','Business partner Questionnaire.pdf', [
                'mime' => 'application/pdf'
            ]);
            
        }else{
            return $this->view('ethics.mails.partnerRegistered')->with(['p'=>$this->partner])
            ->attachFromStorageDisk('myDisk', $this->partner->uuid.'/BPForm.pdf','Business partner Form.pdf', [
                'mime' => 'application/pdf'
            ]);

        }

        
        
    }
}
