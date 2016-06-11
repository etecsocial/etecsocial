<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Desafio extends Model
{
    public $responsible = 'Professor UNK';
    
    public function responsible(){
        return User::select('name')->where('id', $this->responsible_id)->limit(1)->first()->name;
    }
}
