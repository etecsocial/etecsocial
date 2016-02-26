<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Controllers\Controller;
use App\Chat;

class ChatController extends Controller
{   
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function pagina() {
        Return view("chat.pagina");
    }
    
    
    public function enviar(Request $request)
    {
        Chat::create([
            'id_remetente'      => Auth::user()->id,
            'id_destinatario'   => $request->id,
            'msg'               => $request->msg,
            'data'              => time()
        ]);
    }
    
    public function abrir(Request $request) {
        
        if ($request->data) {
            
              $msgs = Chat::where([ "id_remetente" => $request->id_user, "id_destinatario" => Auth::user()->id ])
                ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $request->id_user ])
                      ->where("data", "<", $request->data)
                 ->orderBy('data', 'desc')
                 ->limit(15)
                 ->get()
                 ->toArray();
         } else {

         $msgs = Chat::where([ "id_remetente" => $request->id_user, "id_destinatario" => Auth::user()->id ])
                ->orWhere([ "id_remetente" => Auth::user()->id, "id_destinatario" => $request->id_user ])
                 ->orderBy('data', 'desc')
                 ->limit(15)
                 ->get()
                 ->toArray();
         }
                 
              
         
         
         return view("chat.msgs", [ 'msgs' => $msgs, 'id_user' => $request->id_user ]);
    }
    
     public function channel(Request $request){
        // How often to poll, in microseconds (1,000,000 μs equals 1 s)
define('MESSAGE_POLL_MICROSECONDS', 500000);
 
// How long to keep the Long Poll open, in seconds
define('MESSAGE_TIMEOUT_SECONDS', 5);
 
// Timeout padding in seconds, to avoid a premature timeout in case the last call in the loop is taking a while
define('MESSAGE_TIMEOUT_SECONDS_BUFFER', 5);
 

 
// Close the session prematurely to avoid usleep() from locking other requests
session_write_close();
 
// Automatically die after timeout (plus buffer)
set_time_limit(MESSAGE_TIMEOUT_SECONDS+MESSAGE_TIMEOUT_SECONDS_BUFFER);
 
// Counter to manually keep track of time elapsed (PHP's set_time_limit() is unrealiable while sleeping)
$counter = MESSAGE_TIMEOUT_SECONDS;
 
// Poll for messages and hang if nothing is found, until the timeout is exhausted
while($counter > 0)
{ 
    if ($request->id) {
  $msg = Chat::where([ 'id_destinatario' => Auth::user()->id, 'id_remetente' => $request->id ])
                ->where('data', '>', $request->data)
                ->count();
  
   
// Check for new data (not illustrated)
    if($msg)
    {
        $msgs = Chat::where([ 'id_destinatario' => Auth::user()->id, 'id_remetente' => $request->id ])
                ->where('data', '>', $request->data)
                ->get();
        
        return view("chat.msgs", [ 'msgs' => $msgs, 'id_user' => $request->id ]);
    }
    else
    {
        // Otherwise, sleep for the specified time, after which the loop runs again
        usleep(MESSAGE_POLL_MICROSECONDS);
 
        // Decrement seconds from counter (the interval was set in μs, see above)
        $counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
    }
    
    } else { 
         usleep(MESSAGE_POLL_MICROSECONDS);
 
        // Decrement seconds from counter (the interval was set in μs, see above)
        $counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
    }
}

 
// If we've made it this far, we've either timed out or have some data to deliver to the client

    // Send data to client; you may want to precede it by a mime type definition header, eg. in the case of JSON or XML



    } 
}
