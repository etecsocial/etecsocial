<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notificacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

use Event;
use App\Events\Notificacao;

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
            'id_rem'  => auth()->user()->id,
            'id_dest' => $id_dest,
            'data'    => Carbon::today()->timestamp,
            'texto'   => $texto,
        ]);
        
        Event::fire(new Notificacao($id_dest));
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

    public function newnoti(Request $request)
    {
        $not = Notificacao::where('id_dest', auth()->user()->id)
            ->where('data', '>', $request->data)
            ->where('data', '<', time())
            ->orderBy('data', 'desc')
            ->get();

        return view('notificacao.new', ['nots' => $not]);
    }

    public function makeRead()
    {
        Notificacao::where(['id_dest' => auth()->user()->id, 'visto' => 0])->update(['visto' => 1]);

        return Response::json(["status" => true]);
    }
}
