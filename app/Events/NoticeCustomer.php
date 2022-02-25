<?php

namespace App\Events;

use App\Models\Inquire;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoticeCustomer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $inquire;

    public function __construct(Inquire $inquire)
    {
        $this->inquire = $inquire;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('noticecustomer'.$this->inquire->user_id);
    }
}
