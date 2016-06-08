<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notificacao extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct($id_user)
    {
        $this->data = array(
            'num' => '1',
            'id_user'=> $id_user,
        );
    }

    public function broadcastOn()
    {
        return ['channel'];
    }
}
