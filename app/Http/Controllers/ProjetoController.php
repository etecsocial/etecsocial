<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Response;
use Mail;
use Validator;

class ProjetoController extends Controller
{    
    public function index()
    {	
        return view('projeto.home');
    }
    
    public function sendmail(Request $request) 
    {   
        $validator = Validator::make($request->all(), [
            'email' => 'checkmail'
        ]);
        
        if ($validator->fails()) {
            return Response::json([ 
                "titulo" => "Error", 
                "msg" => "E-mail inexiste." 
            ]);
        }
        
        Mail::send('emails.projeto', $request->all(), function($message) use ($request) {
            $message->from($request->email, $request->nome);
            $message->to('contato@etecsocial.com.br', 'ETEC Social')->subject('Formulário de Resposta');
        });
        
        return Response::json([ 
            "titulo" => "Sucesso!", 
            "msg" => "Contato enviado com sucesso."
        ]);
    }
}
