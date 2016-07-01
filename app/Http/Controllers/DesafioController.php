<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mensagens;
use App\Pontuacao;
use App\User;
use Illuminate\Http\Request;
use App\Desafio;
use App\DesafioTurma;
use App\DesafioResposta;

class DesafioController extends Controller
{
    public function index()
    {
      if(auth()->user()->type == 1){
          return $this->indexAluno();
      } else {
          return $this->indexProfessor();
      }
    }

    public function indexProfessor(){
        $turmas = auth()->user()->turmas;
        $desafios = Desafio::select('id', 'title', 'subject', 'finish', 'description', 'reward_points', 'responsible_id')
                                  ->where('responsible_id', auth()->user()->id)
                                  ->get();

        return view('desafio.home')->with(['turmas' => $turmas, 'desafios' => $desafios]);
    }

    public function indexAluno(){
      $desafios = Desafio::select('id', 'title', 'subject', 'finish', 'description', 'reward_points', 'responsible_id')
                                ->join('desafio_turmas', 'desafios.id', '=', 'desafio_turmas.desafio_id')
                                ->where('desafio_turmas.turma_id', auth()->user()->turma->turma_id)
                                ->groupBy('desafios.id')
                                ->get();
      return view('desafio.home')->with(['desafios' => $desafios]);
    }

    public function responderForm(Request $request){
        $desafio = Desafio::where('id', $request->id)->first();

        return view('desafio.responder')->with(['desafio' => $desafio]);
    }

    public function responder(Request $request){
        if(Desafio::where('id', $request->desafio_id)->first() != null){
            $resposta = new DesafioResposta;
            $resposta->desafio_id = $request->desafio_id;
            $resposta->aluno_id = auth()->user()->id;
            $resposta->resposta = $request->resposta;
            $resposta->save();

            return "respondido";
        } else {
            return "desafio não existe";
        }
    }

    public function geral()
    {
        $usuarios = Pontuacao::ranking();

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de todas as ETEC']);
    }

    public function etec()
    {
        $usuarios = Pontuacao::ranking('etec');

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking de toda a sua ETEC'])->with(['msgsUnread' => Mensagens::countUnread(), 'infoAcad' => User::getInfoAcademica()]);
    }

    public function turma()
    {
        $usuarios = Pontuacao::ranking('turma');

        return view('desafio.ranking', ['usuarios' => $usuarios, 'tipo' => 'Ranking da sua turma'])->with(['msgsUnread' => Mensagens::countUnread()]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->type < 2) {
            return response('Você não pode adicionar nenhum desafio, apenas resolve-los');
        }

        // validator
        $desafio = new Desafio;
        $desafio->title = $request->title;
        $desafio->description = $request->description;
        $desafio->subject = $request->subject;
        $desafio->responsible_id = auth()->user()->id;
        $desafio->finish = $request->finish;
        $desafio->reward_points = $request->reward_points;
        $desafio->file = ''; // @TODO later

        $desafio->save();

        // caso só tiver uma turma
        if(!is_array($request->turmas)){
            $request->turmas = [$request->turmas];
        }

        foreach($request->turmas as $turma){
          $desafio_turma = new DesafioTurma;
          $desafio_turma->desafio_id = $desafio->id;
          $desafio_turma->turma_id = $turma;
        }

        return response()->json(['status' => true, 'text' => 'Desafio adicionado com sucesso']);
    }

    public function edit(Request $request){

    }

    public function delete(Request $request){
        if(Desafio::find($request->id)){ // check if exists Desafio
            $check_responsability = Desafio::select('id')->where('responsible_id', auth()->user()->id)->first();
            if($check_responsability){
                $check_responsability->delete();
                return response()->json(['status' => true, 'text' => 'Desafio excluido']);
            } else {
                return response()->json(['status' => false, 'text' => 'Você não pode excluir essa desafio pois não é de sua autoria']);
            }
        } else {
          return response()->json(['status' => false, 'text' => 'Desafio não existe']);
        }
    }
}
