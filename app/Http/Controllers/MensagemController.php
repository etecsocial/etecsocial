<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mensagens;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use Response;

/**
 * Classe controladora de mensagens
 *
 * @2016 ETEC Social
 */
class MensagemController extends Controller {

    public $extensionImg = ['jpg', 'jpeg', 'JPG', 'png', 'PNG', 'gif'];
    public $extensionVideos = ['flv', 'FLV', 'mp4', 'MP4', 'avi'];
    public $extensionDocs = ['pdf', 'txt', 'doc', 'docx', 'pptx', 'xls'];
    public $ImgDestinationPath = 'midia/imagens/mensagens';
    public $VideoDestinationPath = 'midia/videos/mensagens';
    public $DocsDestinationPath = 'docs/mensagens';

    public function index() {
        Carbon::setLocale('pt_BR');
        $rec = Mensagens::loadRecentes();
        return view('mensagens.home', [
            'myAvatar' => User::myAvatar(),
            'conversas' => Mensagens::loadConversas(),
            'users1' => $rec[0],
            'users2' => $rec[1]
        ]);
    }

    public function getUsersRecents() {
        $rec = Mensagens::loadRecentes();
        return view('mensagens.users')->with(['users1' => $rec[0], 'users2' => $rec[1]]);
    }

    public function getUsersFriends() {
        return view('mensagens.users')->with(['users1' => Mensagens::loadFriends()]);
    }

    public function getUsersArchives() {
        $rec = Mensagens::loadArchives();
        return view('mensagens.users')->with(['users1' => $rec[0], 'users2' => $rec[1], 'archives' => true]);
    }

    public function getUsersUnreads() {
        return view('mensagens.users')->with(['users1' => Mensagens::loadUnreads(), 'thisUser' => auth()->user()]);
    }

    public function arquivarMensagem(Request $request) {
        $rem = Mensagens::where("id", $request->id)->select(['remetente_id'])->first();
        if ($rem->remetente_id == auth()->user()->id) {
            return Mensagens::where("id", $request->id)->update(['arquivado_rem' => 1]);
        }return Mensagens::where("id", $request->id)->update(['arquivado_dest' => 1]);
    }

    public function desarquivarMensagem(Request $request) {
        $rem = Mensagens::where("id", $request->id)->select(['remetente_id'])->first();
        if ($rem->remetente_id == auth()->user()->id) {
            return Mensagens::where("id", $request->id)->update(['arquivado_rem' => 0]);
        }return Mensagens::where("id", $request->id)->update(['arquivado_dest' => 0]);
    }

    public function store(Request $request) {
        if ($request->msg) {
            //if(Input::hasFile('midia')){return Response::json([ 'status' => 'achou']);}

            if (Input::hasFile('midia')) {
                $ext = Input::file('midia')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionImg)) {
                    Input::file('midia')->move($this->ImgDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $midia = $this->ImgDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } elseif (in_array($ext, $this->extensionVideos)) {
                    Input::file('midia')->move($this->VideoDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $midia = $this->VideoDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } else {
                    return Response::json(['status' => false]);
                }
            }
            if (Input::hasFile('doc')) {
                $ext = Input::file('doc')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionDocs)) {
                    Input::file('doc')->move($this->DocsDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $doc = $this->DocsDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } else {
                    return Response::json(['status' => false]);
                }
            }

            $this->create($request->id_dest, $request->msg, $request->assunto, isset($doc) ? $doc : false, isset($midia) ? $midia : false);
            $lastMsg = Mensagens::lastMsg($request->id_dest);

            return Response::json([
                        'status' => true,
                        'last_msg' => $lastMsg->msg,
                        'is_rem' => $lastMsg ? ($lastMsg->remetente_id == auth()->user()->id ? true : false) : false,
                        'user_id' => $lastMsg->remetente_id == auth()->user()->id ? $lastMsg->destinatario_id : $lastMsg->remetente_id,
                        'nome_user' => User::verUser(auth()->user()->id)->nome,
                        'qtd_msgs' => ($qtd = Mensagens::countMsgsTopic($request->id_dest) > 1) ? $qtd . ' mensagens' : '1 mensagem',
            ]);
        }return Response::json(['status' => false]);
    }

    public function create($id_dest, $msg, $assunto, $doc, $img) {
        return Mensagens::create([
                    'remetente_id' => auth()->user()->id,
                    'destinatario_id' => $id_dest,
                    'msg' => $msg,
                    'doc' => isset($doc) ? $doc : null,
                    'midia' => isset($img) ? $img : null,
                    'assunto' => $assunto,
        ]);
    }

    public function getConversa(Request $request) {
        return view('mensagens.conversa', ['conversas' => Mensagens::loadMsgs($request->user_id)]);
    }

    public function getConversaArchives(Request $request) {
        return view('mensagens.conversa', ['conversas' => Mensagens::loadMsgsArchives($request->user_id), 'archive' => true]);
    }

    public function delMensagem(Request $request) {
        if ($msg2 = $msg = Mensagens::where('id', $request->id)->first()) {
            $response = (($msg->remetente_id == auth()->user()->id) ? (($msg->copia_rem == 0) ? '404' : $msg->copia_rem = 0) : (($msg->copia_dest == 0) ? '404' : $msg->copia_dest = 0));
            if ($response != 0) {
                return Response::json(['status' => $response]);
            }
            (($msg->copia_rem == 0) and ( $msg->copia_dest == 0)) ? $msg->delete() : $msg->save();
            $lastMsg = Mensagens::lastMsg($msg->remetente_id == auth()->user()->id ? $msg->destinatario_id : $msg->remetente_id);
            return Response::json([
                        'status' => true,
                        'last_msg' => $lastMsg ? $lastMsg->msg : false,
                        'qtd_msgs' => Mensagens::countMsgsTopic($msg2->remetente_id == auth()->user()->id ? $msg2->destinatario_id : $msg2->remetente_id),
                        'is_rem' => $lastMsg ? ($lastMsg->remetente_id == auth()->user()->id ? true : false) : false,
                        'user_id' => $msg2->remetente_id == auth()->user()->id ? $msg2->destinatario_id : $msg2->remetente_id,
                        'auth()->user()->id' => auth()->user()->id,
                        'nome_user' => User::verUser($msg2->remetente_id == auth()->user()->id ? $msg2->destinatario_id : $msg2->remetente_id)->nome,
            ]);
        }return Response::json(['status' => '404']);
    }

    public function delConversa(Request $request) {
        Mensagens::where(['remetente_id' => auth()->user()->id, 'destinatario_id' => $request->uid])->update(['copia_rem' => 0]);
        Mensagens::Where(['destinatario_id' => auth()->user()->id, 'remetente_id' => $request->uid])->update(['copia_dest' => 0]);
        return Response::json(['status' => true,
                    'nome_user' => User::verUser($request->uid)->nome]);
    }

    public function delConversaArquivada(Request $request) {
        Mensagens::where(['remetente_id' => auth()->user()->id, 'destinatario_id' => $request->uid])->where('arquivado_rem', 1)->update(['copia_rem' => 0]);
        Mensagens::Where(['destinatario_id' => auth()->user()->id, 'remetente_id' => $request->uid, 'arquivado_dest' => 1])->update(['copia_dest' => 0]);
        return Response::json(['status' => true,
                    'nome_user' => User::verUser($request->uid)->nome]);
    }

    public function setImg() {
        if (Input::hasFile('midia')) {
            $ext = Input::file('midia')->getClientOriginalExtension();
            if (in_array($ext, $this->extensionImg)) {
                Input::file('midia')->move($this->ImgDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                $caminho = $this->ImgDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
            } else {
                return 1; //Não é imagem válidda!!
            }
        }
        return isset($caminho) ? $caminho : false;
    }

    public function setDoc() {
        if (Input::hasFile('doc')) {
            $ext = Input::file('doc')->getClientOriginalExtension();
            if (in_array($ext, $this->extensionDocs)) {
                Input::file('doc')->move($this->DocsDestinationPath, md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext);
                $caminho = $this->DocsDestinationPath . '/' . md5(auth()->user()->id . \Carbon\Carbon::now()) . '.' . $ext;
            } else {
                return 1; //Não é documento válido!!
            }
        }
        return isset($caminho) ? $caminho : false;
    }

}
