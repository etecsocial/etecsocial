<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Auth;

class MensagemChat extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct($id_dest, $id_rem, $msg, $data)
    {
        $this->data = array(
            'id_user' => $id_dest,
            'id_rem' => $id_rem,
            'foto_rem' => \App\User::avatar($id_rem),
            'msg' => $msg,
            'data' => $data
        );
    }

    public function broadcastOn()
    {
        return ['channel'];
    }
}
