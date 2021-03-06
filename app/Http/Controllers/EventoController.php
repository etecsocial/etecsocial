<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Grupo;
use App\GrupoUser;
use App\Notificacao;
use App\User;
use Illuminate\Http\Request;
use Input;
use Response;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('agenda.home');
    }

    public function show(Request $request)
    {
        $evento = Evento::select(['eventos.id', 'user_id', 'is_publico', 'start', 'end', 'title', 'description', 'users.name'])
                ->where(function ($query) use ($request) {
                    $query->where('start', '>=', $request->start)
                    ->where('end', '<', $request->end);
                })
                ->where(function ($query) {
                    $query->orWhere(function ($query) {
                        $turma_id = auth()->user()->turma->turma_id;
                        $query->where('eventos.turma_id', $turma_id)
                        ->where('is_publico', 1);
                    })
                    ->orWhere('user_id', auth()->user()->id);
                })
                ->join('users', 'eventos.user_id', '=', 'users.id')
                ->get();

        return Response::json($evento);
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
            $data = $request->start ? $request->start : date('Y-m-d');

            Notificacao::create([
                'rem_id' => auth()->user()->id,
                'id_dest' => auth()->user()->id,
                'data' => strtotime($data) - 3 * 24 * 60 * 60,
                'texto' => 'O evento "'.$request->title.'" está próximo.',
                'is_post' => false,
            ]);

            $turma_id = auth()->user()->turma->turma_id;

            return Evento::create([
                        'title' => $request->title,
                        'start' => $data,
                        'end' => $request->end ? $request->end : $request->start,
                        'user_id' => auth()->user()->id,
                        'is_publico' => $request->publico,
                        'turma_id' => $turma_id,
                        'description' => $request->description,
            ]);
        } else {
            $request->turma ? $this->CreateGrupoByTurma($request->turma, $request->title, $request->start, $request->end, $request->description) : null;
            $request->turma_id ? $this->CreateGrupoByTurma($request->turma_id, $request->title, $request->start, $request->end, $request->description) : null;

            return Evento::create([
                        'title' => $request->title,
                        'start' => $request->start ? $request->start : date('Y-m-d'),
                        'end' => $request->end ? $request->end : $request->start,
                        'user_id' => auth()->user()->id,
                        'is_publico' => $request->publico,
                        'turma_id' => 1,
                        'description' => $request->description,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function makeUrl($nome)
    {
        $url = str_replace(' ', '', $nome);
        $cont = 1;
        while (Grupo::where('url', $url)->select('id')->first()) {
            //falta deixar usar url de grupo expirado
            $url = $url.$cont;
            ++$cont;
        }

        return $url;
    }

    public function CreateGrupoByTurma($turma_id, $titulo, $start, $end, $desc)
    {

        //Automatizar isso, usar o service provider!!

        if (Grupo::create([
                    'nome' => $titulo,
                    'assunto' => isset($desc) ? $desc : 'Grupo de estudos',
                    'url' => $this->makeUrl($titulo),
                    'id_criador' => auth()->user()->id,
                    'criacao' => Carbon::today(),
                    'expiracao' => isset($end) ? $end : $start,
                ])) {
            $alunos = User::where('turma_id', $turma_id)->select('id')->where('id', '<>', auth()->user()->id)->get();
            foreach ($alunos as $aluno) {
                $grupoUser = new GrupoUser();
                $grupoUser->grupo_id = $grupo->id;
                $grupoUser->user_id = $aluno->id;
                $grupoUser->is_admin = 0;
                $grupoUser->save();
                Notificacao::create([
                    'rem_id' => auth()->user()->id,
                    'id_dest' => $aluno->id,
                    'data' => time(),
                    'texto' => 'Adicionou você ao grupo "'.Grupo::verGrupo($grupo->id)->url.'"',
                    'is_post' => false,
                    'action' => '/grupo/'.Grupo::verGrupo($grupo->id)->url,
                ]);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $evento = Evento::where('id', $id)->limit(1)->first();

        $start = Input::has('start') ? Input::get('start') : $evento->start;
        $end = Input::has('end') ? Input::get('end') : $evento->end;

        if (auth()->user()->id !== $evento->user_id) {
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
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $evento = Evento::where('id', $id)->limit(1)->first();

        if (auth()->user()->id !== $evento->user_id) {
            return Response::json(['status' => false]);
        }

        $evento->delete();

        return Response::json(['status' => true]);
    }
}
