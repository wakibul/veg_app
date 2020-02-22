<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class OrderPusherEvent  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    public $confirm_url;
    public $order_time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $order->order_no = $order->order_no ?? "NA";
        $order->order_time = date("d-m-Y h:i a", strtotime($order->order_time));
        $this->order = $order;
        $this->confirm_url = route("admin.dashboard.order.accept", Crypt::encrypt($order->id));
        $this->order_time = date("d-m-Y h:i a", strtotime($order->order_time));
        Log::info($order);
        return "event fired.";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       return ["dashboard-update"];

    }
    public function broadcastAs()
    {
        return "order-created";
    }
}
