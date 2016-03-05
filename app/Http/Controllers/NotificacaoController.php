<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Notificacao; 

use Auth;
use Response;

use Carbon\Carbon;

class NotificacaoController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($texto, $id_dest)
    {
        DB::table('notificacao')->insert([
           'id_rem'=> Auth::user()->id,
           'id_dest' => $id_dest,
           'data' => Carbon::today()->timestamp,
           'texto'=>$texto               
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function newnoti(Request $request ) {
        $not = Notificacao::where('id_dest', Auth::user()->id)
                ->where('data', '>', $request->data)
                ->where('data', '<', time())
                ->orderBy('data', 'desc')
                ->get();
        
         
        return view('notificacao.new', ['nots' => $not ]);
    }
        
    
    public function makeRead() {
       Notificacao::where([ 'id_dest' => Auth::user()->id, 'visto' => 0 ])->update([ 'visto' => 1 ]);
       
       return Response::json(["status" => true]); 
    }
    
    public function channel(Request $request){
        // How often to poll, in microseconds (1,000,000 μs equals 1 s)
define('MESSAGE_POLL_MICROSECONDS', 500000);
 
// How long to keep the Long Poll open, in seconds
define('MESSAGE_TIMEOUT_SECONDS', 30);
 
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
    if (!Auth::check()) {
    return abort(401);
}

    
  $not = Notificacao::where('id_dest', Auth::user()->id)
                ->where('data', '>', $request->data)
                ->where('data', '<', time())
                ->orderBy('data', 'desc')
                ->count();
  
   $count = Notificacao::count();
// Check for new data (not illustrated)
    if($not AND ($count != $request->num))
    {
      

        
       return $count;
       
    }
    else
    {
     
        // Otherwise, sleep for the specified time, after which the loop runs again
        usleep(MESSAGE_POLL_MICROSECONDS);
 
        // Decrement seconds from counter (the interval was set in μs, see above)
        $counter -= MESSAGE_POLL_MICROSECONDS / 1000000;
    }
    

}
 
// If we've made it this far, we've either timed out or have some data to deliver to the client

    // Send data to client; you may want to precede it by a mime type definition header, eg. in the case of JSON or XML

return Notificacao::count();

    } 
}
