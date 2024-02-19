<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NewTrade implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $message;
    private $reciver_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reciver_id,$message)
    {
        $this->message = $message;
        $this->reciver_id = $reciver_id;
    }
    public function broadcastWith()
    {
        $user=User::find($this->reciver_id);
            return [
                'message' => $this->message,
                'sender' => Auth::user()->first_name.' '.Auth::user()->last_name,
                'sender_id' => Auth::id(),
                'reciver' => $user->first_name.' '.$user->last_name,
                'reciver_id' => $user->id,
            ];

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('message');
    }
}
