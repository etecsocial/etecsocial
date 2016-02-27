<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agenda;
use App\Notificacao;
use App\Grupo;
use App\User;
use App\GrupoUsuario;
use Input;
use Auth;
use Response;

class AgendaController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('agenda.home');
    }

    public function api(Request $request) {
        $agenda = Agenda::select(['agendas.id', 'id_user', 'is_publico', 'start', 'end', 'title', 'description', 'users.nome'])
                ->where(function ($query) use ($request) {
                    $query->where('start', '>=', $request->start)
                    ->where('end', '<', $request->end);
                })
                ->where(function ($query) {
                    $query->orWhere(function ($query) {
                        $query->where('agendas.id_turma', Auth::user()->id_turma)
                            ->where('agendas.id_modulo', Auth::user()->id_modulo)
                            ->where('is_publico', 1);
                    })
                    ->orWhere('id_user', Auth::user()->id);
                })
                ->join('users', 'agendas.id_user', '=', 'users.id')
                ->get();

        return Response::json($agenda);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [ 'title' => 'required']);

        if (Auth::user()->tipo == 1) {
            $data = $request->start ? $request->start : date("Y-m-d");

            Notificacao::create([
                'id_rem' => Auth::user()->id,
                'id_dest' => Auth::user()->id,
                'data' => strtotime($data) - 3 * 24 * 60 * 60,
                'texto' => 'O evento "' . $request->title . '" está próximo.',
                'is_post' => false,
            ]);

            return Agenda::create([
                        'title' => $request->title,
                        'start' => $data,
                        'end' => $request->end ? $request->end : $request->start,
                        'id_user' => Auth::user()->id,
                        'is_publico' => $request->publico,
                        'id_turma' => Auth::user()->id_turma,
                        'id_modulo' => Auth::user()->id_modulo,
                        'description' => $request->description
            ]);
        } else {
            $request->turma ? $this->CreateGrupoByTurma($request->turma, $request->title, $request->start, $request->end, $request->description) : null;
            $request->id_turma ? $this->CreateGrupoByTurma($request->id_turma, $request->title, $request->start, $request->end, $request->description) : null;
            return Agenda::create([
                        'title' => $request->title,
                        'start' => $request->start ? $request->start : date("Y-m-d"),
                        'end' => $request->end ? $request->end : $request->start,
                        'id_user' => Auth::user()->id,
                        'is_publico' => $request->publico,
                        'id_turma' => $request->turma,
                        'id_modulo' => $request->modulo,
                        'description' => $request->description
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function CreateGrupoByTurma($id_turma, $titulo, $start, $end, $desc) {
        $nome = str_replace(' ', '', $titulo);
        if (Grupo::where('url', $nome)->first()) {
            $url = $nome . 1;
            $cont = 1;
            while (Grupo::where('url', $url)->first()) {
                $cont = $cont + 1;
                $url = $nome . $cont;
            }
        }
        $grupo = new Grupo;
        $grupo->nome = $titulo;
        $grupo->assunto = isset($desc) ? $desc : 'Grupo de estudos';
        $grupo->url = isset($url) ? $url : $nome;
        $grupo->id_criador = Auth::user()->id;
        $grupo->num_participantes = 1;
        $grupo->criacao = \Carbon\Carbon::today();
        $grupo->expiracao = isset($end) ? $end : $start;

        if ($grupo->save()) {
            $grupoUsuario = new GrupoUsuario;
            $grupoUsuario->id_grupo = $grupo->id;
            $grupoUsuario->id_user = $grupo->id_criador;
            $grupoUsuario->is_admin = 1;
            $grupoUsuario->save();
            $alunos = User::where('id_turma', $id_turma)->select(['id'])->where('id', '<>', Auth::User()->id)->get();
            foreach ($alunos as $aluno) {
                $grupoUsuario = new GrupoUsuario;
                $grupoUsuario->id_grupo = $grupo->id;
                $grupoUsuario->id_user = $aluno->id;
                $grupoUsuario->is_admin = 0;
                $grupoUsuario->save();
                Notificacao::create([
                    'id_rem' => Auth::user()->id,
                    'id_dest' => $aluno->id,
                    'data' => time(),
                    'texto' => 'Adicionou você ao grupo "' . Grupo::verGrupo($grupo->id)->url . '"',
                    'is_post' => false,
                    'action' => '/grupo/' . Grupo::verGrupo($grupo->id)->url
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
    public function edit($id) {
        $evento = Agenda::where('id', $id)->limit(1)->first();

        $start = Input::has('start') ? Input::get('start') : $evento->start;
        $end = Input::has('end') ? Input::get('end') : $evento->end;

        if (Auth::user()->id !== $evento->id_user) {
            return abort(500);
        }

        $evento->start = $start;
        $evento->end = $end;
        $evento->save();

        return Response::json(['status' => 'true']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $evento = Agenda::where('id', $id)->limit(1)->first();

        if (Auth::user()->id !== $evento->id_user) {
            return Response::json(['status' => false]);
        }

        $evento->delete();

        return Response::json(['status' => true]);
    }
}