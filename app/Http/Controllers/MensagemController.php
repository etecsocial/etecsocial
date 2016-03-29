<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Response;
use Auth;
use App\Mensagens;
use DB;
use Input;

/**
 * Classe controladora de mensagens
 *
 * @2016 ETEC Social
 */
class MensagemController extends Controller {

    public $extensionImg = ['jpg', 'JPG', 'png', 'PNG', 'gif'];
    public $extensionVideos = ['flv', 'FLV', 'mp4', 'MP4', 'avi'];
    public $extensionDocs = ['pdf', 'txt', 'doc', 'docx', 'pptx', 'xls'];
    public $ImgDestinationPath = 'midia/imagens/chats';
    public $VideoDestinationPath = 'midia/videos/chats';
    public $DocsDestinationPath = 'docs/chats';
    

    public function index() {
        Carbon::setLocale('pt_BR');
        return view('mensagens.home', [
            'uid' => Auth::user()->id,
            'myAvatar' => User::myAvatar(),
            'conversas' => Mensagens::loadConversas(),
            'users' => Mensagens::loadRecentes(),
            'unread' => Mensagens::countUnread(),
            'thisUser' => Auth::user(),
            'msgsUnread' => Mensagens::countUnread()
        ]);
    }

    public function store(Request $request) {
        if ($request->msg) {
            Carbon::setLocale('pt_BR');
            Mensagens::store($request->id_dest, $request->msg, $request->assunto);
            $lastMsg = Mensagens::lastMsg($request->id_dest);
            
            return Response::json([ 
                'status' => true, 
                'last_msg' => $lastMsg->msg, 
                'is_rem' => $lastMsg ? ($lastMsg->id_remetente == Auth::user()->id ? true : false) : false,
                'id_user' => $lastMsg->id_remetente == Auth::user()->id ? $lastMsg->id_destinatario : $lastMsg->id_remetente,
                'auth_id' => Auth::user()->id,
                'nome_user' => User::verUser(Auth::user()->id)->nome,
                'qtd_msgs' => ($qtd = Mensagens::countMsgsTopic($request->id_dest) > 1) ? $qtd.' mensagens' : '1 mensagem'
                ]);
        }return Response::json([ 'status' => false]);
    }

    public function getConversa(Request $request) {
        Carbon::setLocale('pt_BR');
        return view('mensagens.conversa', ['conversas' => Mensagens::loadMsgs($request->id_user)]);
    }

    public function delMensagem(Request $request) {
        if ($msg2 = $msg = Mensagens::where('id', $request->id)->first()) {
            Carbon::setLocale('pt_BR');
            $response = (($msg->id_remetente == Auth::user()->id) ? (($msg->copia_rem == 0) ? '404' : $msg->copia_rem = 0) : (($msg->copia_dest == 0) ? '404' : $msg->copia_dest = 0));
            if($response != 0) {return Response::json([ 'status' => $response]);}
            (($msg->copia_rem == 0) and ( $msg->copia_dest == 0)) ? $msg->delete() : $msg->save();
            $lastMsg = Mensagens::lastMsg($msg->id_remetente == Auth::user()->id ? $msg->id_destinatario : $msg->id_remetente);
            return Response::json([
                'status' => true, 
                'last_msg' => $lastMsg ? $lastMsg->msg : false,
                'qtd_msgs' => Mensagens::countMsgsTopic($msg2->id_remetente == Auth::user()->id ? $msg2->id_destinatario : $msg2->id_remetente),
                'is_rem' => $lastMsg ? ($lastMsg->id_remetente == Auth::user()->id ? true : false) : false,
                'id_user' => $msg2->id_remetente == Auth::user()->id ? $msg2->id_destinatario : $msg2->id_remetente,
                'auth_id' => Auth::user()->id,
                'nome_user' => User::verUser($msg2->id_remetente == Auth::user()->id ? $msg2->id_destinatario : $msg2->id_remetente)->nome
                ]);
        }return Response::json([ 'status' => '404']);
    }
    
    

    public function setMidia(Request $request) {
        if (($request->img) || ($request->doc) || ($request->video)) {
            $msg = new Chat;
            $msg->id_remetente = Auth::user()->id;
            $msg->id_destinatario = $request->id_dest;
            if (Input::hasFile('img')) {
                $ext = Input::file('img')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionImg)) {
                    Input::file('img')->move($this->ImgDestinationPath, md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $msg->img = $this->ImgDestinationPath . '/' . md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } else {
                    return Response::json([ 'response' => 4]); //Não é imagem válidda!!
                }
            } elseif (Input::hasFile('doc')) {
                $ext = Input::file('doc')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionDocs)) {
                    Input::file('doc')->move($this->DocsDestinationPath, md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $msg->doc = $this->DocsDestinationPath . '/' . md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } else {
                    return Response::json([ 'response' => 4]); //Não é documento válido!!
                }
            } elseif (Input::hasFile('video')) {
                $ext = Input::file('video')->getClientOriginalExtension();
                if (in_array($ext, $this->extensionVideos)) {
                    Input::file('video')->move($this->VideoDestinationPath, md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext);
                    $msg->video = $this->VideoDestinationPath . '/' . md5(Auth::User()->id . \Carbon\Carbon::now()) . '.' . $ext;
                } else {
                    return Response::json([ 'response' => 4]); //Não é documento válido!!
                }
            }
            return $msg->save() ? Response::json([ 'status' => true]) : Response::json([ 'status' => false]);
        }return Response::json([ 'response' => 3]); //Não é nenhuma fucking mídia!
    }

}
