<?php

namespace App\Events\Ethics;

use App\Models\Ethics\Partner;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;



class PublicPartnerRegistrationInitiated implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $partner;
    public function __construct(Partner $partner)
    {
        
        $this->partner=$partner;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
