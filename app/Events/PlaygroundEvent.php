<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bid;

class PlaygroundEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;
    public $username;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Bid $bidd,$username)
    {
        $this->bid = $bidd;
        $this->username=$username;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public.bid.1');
    }

    public function broadcastAs(){
        return 'newBid';
    }

    public function broadcastWith(){
        $array = $this->bid->toArray();
        $array['username'] = $this->username;
        return $array;
    }


}
