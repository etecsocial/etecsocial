<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notificacao extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct($user_id)
    {
        $this->data = array(
            'num' => '1',
            'user_id'=> $user_id,
        );
    }

    public function broadcastOn()
    {
        return ['channel'];
    }
}
