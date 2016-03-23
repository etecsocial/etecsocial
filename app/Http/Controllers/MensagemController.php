<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Mensagens;
use Carbon\Carbon;
use Auth;
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
            'conversas' => Mensagens::loadConversas(),
            'users' => Mensagens::loadUsers(),
            'unread' => Mensagens::count()
                ]);
    }

    public function store(Request $request) {
        if ($request->msg) {
            Chat::create([
                'id_remetente' => Auth::user()->id,
                'id_destinatario' => $request->id_dest,
                'msg' => $request->msg
            ]);
            return Response::json([ 'status' => true]); //RETORNAR JUNTO O ID GERADO PARA CONTROLE DE JS!!
        }return Response::json([ 'status' => false]);
    }

    public function destroy(Request $request) {
        if ($msg = Chat::where('id', $request->id)->first()) {
            if (($msg->copia_dest == 0) and ( $request->is_rem) or ( ($msg->copia_rem == 0) and ( $request->is_dest))) {
                $msg->delete();
                return Response::json([ 'status' => true]);
            }
            $request->is_dest ? $msg->dest = 0 : $msg->rem = 0;
            $msg->save();
            return Response::json([ 'status' => true]);
        }return Response::json([ 'status' => false]); //Menságem não existe mais!
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
