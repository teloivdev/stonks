<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\BuyOrder;
use Carbon\Carbon;

class BuyOrderCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $buyOrders;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($playerId)
    {
        $this->buyOrders = BuyOrder::where('player_id', $playerId)->where('filled', '0')->orderBy('price', 'desc')->skip(0)->take(10)->get();
        //return view('player.orders.buyOrders')->with('buyOrders', $this->buyOrders)->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('price');
    }
}
