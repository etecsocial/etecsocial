<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\User;

class MensagemChat extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    public function __construct($id_dest, $rem_id, $msg, $data)
    {
        $this->data = array(
            'user_id' => $id_dest,
            'rem_id' => $rem_id,
            'foto_rem' => User::avatar($rem_id),
            'msg' => $msg,
            'data' => $data
        );
    }

    public function broadcastOn()
    {
        return ['channel'];
    }
}
