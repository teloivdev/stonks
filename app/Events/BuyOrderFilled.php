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
use App\Player;

class BuyOrderFilled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $buyOrder;
    public $player;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($buyOrderId)
    {
        $this->buyOrder = BuyOrder::find($buyOrderId);
        $this->player = Player::find($this->buyOrder->player_id);
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
