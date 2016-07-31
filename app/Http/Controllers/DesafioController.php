<?php

namespace App\Http\Controllers;

use App\Pontuacao;
use App\User;
use Illuminate\Http\Request;
use App\Desafio;
use App\DesafioTurma;
use App\DesafioResposta;
use App\AlunosTurma;
use App\Notificacao;
use Carbon\Carbon;
use Input;

class DesafioController extends Controller
{
    public $anexos = ['jpg', 'png', 'docx', 'pdf', 'xlsx', 'txt'];
    public $anexos_path = 'midia/anexos';

    public function index()
    {
        if (auth()->user()->type == 1) {
            return $this->indexAluno();
        } else {
            return $this->indexProfessor();
        }
    }

    public function indexProfessor()
    {
        $turmas = auth()->user()->turmas;
        $desafios = Desafio::select('id', 'title', 'subject', 'finish', 'description', 'reward_points', 'responsible_id', 'file')
                                  ->where('responsible_id', auth()->user()->id)
                                  ->get();

        return view('desafio.home')->with(['turmas' => $turmas, 'desafios' => $desafios]);
    }

    public function indexAluno()
    {
        $desafios = Desafio::select('id', 'title', 'subject', 'finish', 'description', 'reward_points', 'responsible_id', 'file')
                                ->join('desafio_turmas', 'desafios.id', '=', 'desafio_turmas.desafio_id')
                                ->where('desafio_turmas.turma_id', auth()->user()->turma->turma_id)
                                ->groupBy('desafios.id')
                                ->get();

        return view('desafio.home')->with(['desafios' => $desafios]);
    }

    public function responderForm(Request $request)
    {
        $desafio = Desafio::find($request->id);
        $desafio_com_resposta = Desafio::where('desafios.id', $request->id)
                                      ->join('desafio_respostas', 'desafio_respostas.desafio_id', '=', 'desafios.id')
                                      ->where('desafio_respostas.aluno_id', auth()->user()->id)
                                      ->first();
        if ($desafio == null) {
            return 'Não existe desafios!';
        }

        return view('desafio.responder')->with(['desafio' => $desafio, 'desafio_com_resposta' => $desafio_com_resposta]);
    }

    public function responder(Request $request)
    {
        if (Desafio::where('id', $request->desafio_id)->first() != null) {
            $resposta = new DesafioResposta();
            $resposta->desafio_id = $request->desafio_id;
            $resposta->aluno_id = auth()->user()->id;
            $resposta->resposta = $request->resposta;
            $resposta->save();

            return response()->json(['status' => true, 'text' => 'Resposta ao desafio enviada!']);
        } else {
            return response()->json(['status' => false, 'text' => 'Erro ao enviar!']);
        }
    }

    public function responderExcluir(Request $request)
    {
        if (DesafioResposta::find($request->id)) {
            $check_responsability = DesafioResposta::where('aluno_id', auth()->user()->id);
            if ($check_responsability) {
                $check_responsability->delete();

                return response()->json(['status' => true, 'text' => 'Resposta do desafio excluida']);
            } else {
                return response()->json(['status' => false, 'text' => 'Você não pode excluir uma resposta de um desafio que não é seu!']);
            }
        } else {
            return response()->json(['status' => false, 'text' => 'Resposta não existe']);
        }
    }

    public function responderEditar(Request $request)
    {
        if (DesafioResposta::find($request->id)) {
            $check_responsability = DesafioResposta::where('aluno_id', auth()->user()->id);
            if ($check_responsability) {
                $check_responsability->resposta = $request->resposta;

                return response()->json(['status' => true, 'text' => 'Resposta do desafio editada']);
            } else {
                return response()->json(['status' => false, 'text' => 'Você não pode editar uma resposta de um desafio que não é seu!']);
            }
        } else {
            return response()->json(['status' => false, 'text' => 'Resposta não existe']);
        }
    }

    public function corrigirResposta(Request $request)
    {
        $resposta = DesafioResposta::where('id', $request->resposta_id)->first();
        $resposta->resposta_comentario = $request->resposta_comentario;
        $resposta->corrigida = true;

        if ($request->correcao == 'sim') {
            $resposta->correto = true;
            Notificacao::create([
                'rem_id' => auth()->user()->id,
                'id_dest' => $resposta->aluno->id,
                'data' => time(),
                'texto' => 'Você acertou o desafio: '.$resposta->desafio->title,
                'is_post' => false,
                'action' => '/desafio/responder/'.$resposta->desafio->id,
            ]);
            Pontuacao::pontuar($resposta->desafio->reward_points, 'Acertou ao desafio: '.$resposta->desafio->title, $resposta->aluno->id);
        } elseif ($request->correcao == 'nao') {
            $resposta->correto = false;
            Notificacao::create([
                'rem_id' => auth()->user()->id,
                'id_dest' => $resposta->aluno->id,
                'data' => time(),
                'texto' => 'Você error o desafio: '.$resposta->desafio->title,
                'is_post' => false,
                'action' => '/desafio/responder/'.$resposta->desafio->id,
            ]);
        }

        $resposta->save();
    }

    public function corrigirRespostas(Request $request)
    {
        $respostas = DesafioResposta::where('desafio_id', $request->desafio_id)->get();
        if ($respostas->first() == null) {
            $respostas = [];
        }

        return view('desafio.respostas', ['respostas' => $respostas]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->type < 2) {
            return response('Você não pode adicionar nenhum desafio, apenas resolve-los');
        }

        // validator
        $desafio = new Desafio();
        $desafio->title = $request->title;
        $desafio->description = $request->description;
        $desafio->subject = $request->subject;
        $desafio->responsible_id = auth()->user()->id;
        $desafio->finish = Carbon::createFromTimeStamp(strtotime($request->finish))->format('Y-m-d');
        $desafio->reward_points = $request->reward_points;

        $desafio->save();

        // caso tiver anexo
        if ($request->hasFile('file')) {
            $this->addAnexo($request->file, $desafio);
        }

        // caso só tiver uma turma
        if (!is_array($request->turmas)) {
            $request->turmas = [$request->turmas];
        }

        foreach ($request->turmas as $turma) {
            $desafio_turma = new DesafioTurma();
            $desafio_turma->desafio_id = $desafio->id;
            $desafio_turma->turma_id = $turma;
            $desafio_turma->save();
          // notifica aluno por aluno, isso deveria ser feito com job e queue
          $students = AlunosTurma::select('user_id')->where('turma_id', $turma)->get();
            foreach ($students as $student) {
                Notificacao::create([
                  'rem_id' => auth()->user()->id,
                  'id_dest' => $student->user_id,
                  'data' => time(),
                  'texto' => 'Tem um novo desafio para você resolver: '.$desafio->title,
                  'is_post' => false,
                  'action' => '/desafio/responder/'.$desafio->id,
              ]);
            }
        }

        return redirect('/desafios');
    }

    protected function addAnexo($anexo, $desafio)
    {
        $ext = strtolower($anexo->getClientOriginalExtension());

        if (!in_array($ext, $this->anexos)) {
            return false;
        }

        Input::file('file')->move($this->anexos_path, md5($desafio->id).'.'.$ext);

        $desafio->file = $this->anexos_path.'/'.md5($desafio->id).'.'.$ext;
        $desafio->save();
    }

    public function editForm()
    {
        return 'Editar desafio form';
    }

    public function edit(Request $request)
    {
        if (Desafio::find($request->id)) { // check if exists Desafio
          $desafio = Desafio::select('id')->where('responsible_id', auth()->user()->id)->first();
            if ($desafio) {
                $desafio->title = $request->title;
                $desafio->description = $request->description;
                $desafio->subject = $request->subject;
                $desafio->finish = $request->finish;
                $desafio->reward_points = $request->reward_points;
                $desafio->file = ''; // @TODO later

              $desafio->save();

              // caso só tiver uma turma
              if (!is_array($request->turmas)) {
                  $request->turmas = [$request->turmas];
              }

              // deleta todas as turmas antes
              DesafioTurmas::where('desafio_id', $desafio->id)->delete();

                foreach ($request->turmas as $turma) {
                    $desafio_turma = new DesafioTurma();
                    $desafio_turma->desafio_id = $desafio->id;
                    $desafio_turma->turma_id = $turma;
                }

                return response()->json(['status' => true, 'text' => 'Desafio editado com sucesso']);
            } else {
                return response()->json(['status' => false, 'text' => 'Você não pode editar essa desafio pois não é de sua autoria']);
            }
        } else {
            return response()->json(['status' => false, 'text' => 'Desafio não existe']);
        }
    }

    public function delete(Request $request)
    {
        if (Desafio::find($request->id)) { // check if exists Desafio
            $check_responsability = Desafio::select('id')->where('responsible_id', auth()->user()->id)->first();
            if ($check_responsability) {
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
