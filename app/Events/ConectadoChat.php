<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConectadoChat extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct()
    {
        
    }

    public function broadcastOn()
    {
        return ['channel'];
    }
}
