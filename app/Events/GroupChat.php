<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\GroupChat as ModelsGroupChat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class GroupChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $message;
    private $sender_id;
    private $group_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($group_id,$sender_id,$message,)
    {
        $this->message = $message;
        $this->group_id = $group_id;
        $this->sender_id = $sender_id;

    }
    public function broadcastWith()
    {
        $user=User::find($this->sender_id);
            return [
                'message' => $this->message,
                'sender' => $user->first_name.' '.$user->last_name,
                'sender_id' => $this->sender_id,
                'group_id' => $this->group_id,
            ];

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('groupmessage');
    }
}
