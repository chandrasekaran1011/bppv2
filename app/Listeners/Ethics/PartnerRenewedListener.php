<?php

namespace App\Listeners\Ethics;

use App\Events\Ethics\PartnerRenewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PartnerRenewedListener
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
        //
    }
}
