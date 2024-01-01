<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReviewSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $houseId;
    public $newData;

    /**
     * Create a new event instance.
     */
    public function __construct($houseId, $newData)
    {
        $this->houseId = $houseId;
        $this->newData = $newData;
    }

    public function broadcastWith()
    {
        return [
            'houseId' => $this->houseId,
            'newData' => $this->newData
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        // Log::debug($this->houseId);
        // Log::debug($this->userId);
        // return [
        //     new Channel('review.'. $this->houseId),
        // ];
        return new Channel('review.'. $this->houseId);
    }
}
