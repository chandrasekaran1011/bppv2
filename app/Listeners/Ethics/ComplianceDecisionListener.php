<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\ComplianceDecision;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Ethics\Audit;

class ComplianceDecisionListener
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
     * @param  ComplianceDecision  $event
     * @return void
     */
    public function handle(ComplianceDecision $event)
    {
        $a=new Audit;
            $a->partner_id=$event->partner->id;
            $a->user_id=$event->partner->ethics->ims_by;
            $a->action="Partner : ".$event->partner->ethics->decisionVal($event->partner->ethics->decision);
        $a->save();
        Log::info('Compliance Decision Made: '.$event->partner->name);

    }
}
