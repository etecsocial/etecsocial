<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;
use LRedis;
 
class SocketController extends Controller {
	
	public function index()
	{
		return view('socket.socket');
	}
	public function writemessage()
	{
		return view('socket.writemessage');
	}
	public function sendMessage(){
		$redis = LRedis::connection('tcp://52.67.17.116:6379');
		$redis->publish('message', Request::input('message'));
		return redirect('writemessage');
	}
}
