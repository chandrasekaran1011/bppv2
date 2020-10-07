<?php

namespace App\Jobs\Ethics;

use App\Models\Ethics\Audit;
use App\Models\Ethics\Partner;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Auth;

class RenewalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $partner=Partner::where('status',4)->where('due_on','<',Carbon::now())->get();

        $id=[];
        $expired=[];
        if($partner){
            foreach($partner as $p){

                Log::Info('Update Renewal to partners.'.$p->id.' - '.$p->name );
                array_push($id,$p->id);
                
                $audit=new Audit;
                $audit->partner_id=$p->id;
                $audit->user_id=0;
                $audit->action='Automated Status changed to Partner Expired';
                $audit->save();

            }
        }


        if(count($id)>0){
            $partner=Partner::whereIn('id',$id)->update(['status'=>6]);

            Log::Info('Update Renewal to partners.');
            
        }

        //Ending Deadlines

        $partner=Partner::where('status',6)->where('due_on','<',Carbon::now()->subDays(config('ethics.renewal_expiry',90)))->where('is_renew',false)->where('can_renew',true)->get();
        $id=[];
        if($partner){
            foreach($partner as $p){

                Log::Info('Update Renewal to partners(90days period).'.$p->id.' - '.$p->name );
                array_push($id,$p->id);
                
                $audit=new Audit;
                $audit->partner_id=$p->id;
                $audit->user_id=0;
                $audit->action='Renewal Deadline Ended';
                $audit->save();

            }
        }

        if(count($id)>0){
            $partner=Partner::whereIn('id',$id)->update(['can_renew'=>false]);

            Log::Info('Update Partners ending Renewal Deadline.');
            
        }

    }
}
