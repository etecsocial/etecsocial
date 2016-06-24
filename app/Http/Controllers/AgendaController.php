<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Grupo;
use App\GrupoUsuario;
use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Notificacao;
use App\User;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;

class AgendaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('agenda.home')->with(['thisUser' => auth()->user(), 'msgsUnread' => Mensagens::countUnread(), 'infoAcad' => User::getInfoAcademica()]);
    }

    public function api(Request $request)
    {

        $agenda = Agenda::select(['agendas.id', 'user_id', 'is_publico', 'start', 'end', 'title', 'description', 'users.name'])
            ->where(function ($query) use ($request) {
                $query->where('start', '>=', $request->start)
                    ->where('end', '<', $request->end);
            })
            ->where(function ($query) {
                $query->orWhere(function ($query) {
                    $db       = DB::table('alunos_info')->select('id_turma')->where('user_id', auth()->user()->id)->first();
                    $id_turma = $db->id_turma;
                    $query->where('agendas.id_turma', $id_turma)
                        ->where('is_publico', 1);
                })
                    ->orWhere('user_id', auth()->user()->id);
            })
            ->join('users', 'agendas.user_id', '=', 'users.id')
            ->get();

        return Response::json($agenda);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required']);

        if (auth()->user()->type == 1) {
            $data = $request->start ? $request->start : date("Y-m-d");

            Notificacao::create([
                'id_rem'  => auth()->user()->id,
                'id_dest' => auth()->user()->id,
                'data'    => strtotime($data) - 3 * 24 * 60 * 60,
                'texto'   => 'O evento "' . $request->title . '" está próximo.',
                'is_post' => false,
            ]);

            $db       = DB::table('alunos_info')->select('id_turma')->where('user_id', auth()->user()->id)->first();
            $id_turma = $db->id_turma;

            return Agenda::create([
                'title'       => $request->title,
                'start'       => $data,
                'end'         => $request->end ? $request->end : $request->start,
                'user_id'     => auth()->user()->id,
                'is_publico'  => $request->publico,
                'id_turma'    => $id_turma,
                'description' => $request->description,
            ]);
        } else {
            $request->turma ? $this->CreateGrupoByTurma($request->turma, $request->title, $request->start, $request->end, $request->description) : null;
            $request->id_turma ? $this->CreateGrupoByTurma($request->id_turma, $request->title, $request->start, $request->end, $request->description) : null;
            return Agenda::create([
                'title'       => $request->title,
                'start'       => $request->start ? $request->start : date("Y-m-d"),
                'end'         => $request->end ? $request->end : $request->start,
                'user_id'     => auth()->user()->id,
                'is_publico'  => $request->publico,
                'id_turma'    => 1,
                'description' => $request->description,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function makeUrl($nome)
    {
        $url  = str_replace(' ', '', $nome);
        $cont = 1;
        while (Grupo::where('url', $url)->select('id')->first()) {
//fala deixar usar url de grupo expirado
            $url = $url . $cont;
            $cont++;
        }return $url;
    }

    public function CreateGrupoByTurma($id_turma, $titulo, $start, $end, $desc)
    {

        $grupo                    = new Grupo;
        $grupo->nome              = $titulo;
        $grupo->assunto           = isset($desc) ? $desc : 'Grupo de estudos';
        $grupo->url               = $this->makeUrl($titulo);
        $grupo->id_criador        = auth()->user()->id;
        $grupo->num_participantes = 1;
        $grupo->criacao           = \Carbon\Carbon::today();
        $grupo->expiracao         = isset($end) ? $end : $start;

        if ($grupo->save()) {
            $grupoUsuario           = new GrupoUsuario;
            $grupoUsuario->id_grupo = $grupo->id;
            $grupoUsuario->user_id  = $grupo->id_criador;
            $grupoUsuario->is_admin = 1;
            $grupoUsuario->save();
            $alunos = User::where('id_turma', $id_turma)->select(['id'])->where('id', '<>', auth()->user()->id)->get();
            foreach ($alunos as $aluno) {
                $grupoUsuario           = new GrupoUsuario;
                $grupoUsuario->id_grupo = $grupo->id;
                $grupoUsuario->user_id  = $aluno->id;
                $grupoUsuario->is_admin = 0;
                $grupoUsuario->save();
                Notificacao::create([
                    'id_rem'  => auth()->user()->id,
                    'id_dest' => $aluno->id,
                    'data'    => time(),
                    'texto'   => 'Adicionou você ao grupo "' . Grupo::verGrupo($grupo->id)->url . '"',
                    'is_post' => false,
                    'action'  => '/grupo/' . Grupo::verGrupo($grupo->id)->url,
                ]);
            }return true;
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $evento = Agenda::where('id', $id)->limit(1)->first();

        $start = Input::has('start') ? Input::get('start') : $evento->start;
        $end   = Input::has('end') ? Input::get('end') : $evento->end;

        if (auth()->user()->id !== $evento->user_id) {
            return abort(500);
        }

        $evento->start = $start;
        $evento->end   = $end;
        $evento->save();

        return Response::json(['status' => 'true']);
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
        $evento = Agenda::where('id', $id)->limit(1)->first();

        if (auth()->user()->id !== $evento->user_id) {
            return Response::json(['status' => false]);
        }

        $evento->delete();

        return Response::json(['status' => true]);
    }

}
