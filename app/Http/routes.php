<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::group(array('domain' => 'etec.localhost'), function()
{
    //AUTH
    Route::controllers([ 
        'auth' => 'Auth\AuthController', 
        'password' => 'Auth\PasswordController'
    ]);   
 
    //HOME
    Route::get('/', 'HomeController@index');
    //AGENDA
    Route::get('/agenda', 'AgendaController@index');
    
//PESQUISA
    Route::get('/busca/{termo}', 'PesquisaController@index');    
//GRUPO
    
    Route::get('/grupo/{groupname}', 'GrupoController@index');
    Route::get('/grupos', 'GrupoController@listar');
    //TAREFA
    Route::get('/tarefas', 'TarefaController@index');
    //TAGS
    Route::get('/tag/{tag}', 'TagController@show');    
    //MENSAGENS
    Route::get('/mensagens', 'ChatController@pagina');
    //POST
    Route::get('/post/{id}', 'HomeController@feed');
    //PERFIL
    Route::get('/{username}', 'PerfilController@index');
    Route::get('/perfil/editar', 'PerfilController@update');
    
    //AJAX
    Route::group(['prefix' => 'ajax'], function () {
        //CONTA
        Route::post('/config', 'ContaController@editar');
        //AGENDA
        Route::get('/agenda', 'AgendaController@api');
        Route::resource('/agenda', 'AgendaController');
        //CONTA
        Route::get('/cadastro/escolas', 'ContaController@consultarEscola');
        Route::get('/cadastro/turmas', 'ContaController@consultarTurma');
        //MENSAGEM
        Route::post('/chat/enviar', 'ChatController@enviar');
        Route::post('/chat/abrir', 'ChatController@abrir');
        Route::post('/chat/channel', 'ChatController@channel');
         //PESQUISAR
        Route::get('/buscar', 'PesquisaController@buscaRapida');
        //STATUS
        Route::post('/status', 'PerfilController@status');
        //NEWPOST
        Route::post('/newpost', 'HomeController@newpost');
        Route::post("/perfil/newpost", 'PerfilController@newpost');
        //MOREPOST
        Route::post('/morepost', 'HomeController@morepost');
        Route::post("/perfil/morepost", 'PerfilController@morepost');
        //POST
        Route::resource('/post', 'PostController', ['except' => ['index', 'create', 'edit']]);
        //REPOST
        Route::post('/repost', 'PostController@repost');
        //FAVORITAR
        Route::post('/post/favoritar', 'PostController@favoritar');
        //COMENTARIO
        Route::resource('/comentario', 'ComentarioController', ['except' => ['index', 'create', 'edit']]);
    Route::resource('/discussao', 'DiscussaoController', ['except' => ['index', 'create', 'edit']]);
        Route::resource('/pergunta', 'PerguntaController', ['except' => ['index', 'create', 'edit']]);
        //TAREFA
        Route::post('/tarefas', 'TarefaController@store');
        //MORETASK
        Route::post('/moretask', 'TarefaController@moretask');
        //CHECKTASK
        Route::post('/tarefas/check', 'TarefaController@check');
        //ADDAMIGO
        Route::post('/adicionar', 'PerfilController@addAmigo');
        //RECAMIGO
        Route::post('/recusar', 'PerfilController@recusarAmigo');
        //AGENDA
        Route::get('/agenda', 'AgendaController@api');
        //NOTIFICACAO
        Route::get('/notificacao/makeread', 'NotificacaoController@makeread');
        Route::post('/notificacao/new', 'NotificacaoController@newnoti');
        Route::post('/notificacao/channel', 'NotificacaoController@channel');
                //GRUPO
        Route::post('/grupo/criar', 'GrupoController@criar');
        Route::post('/grupo/addAlunoDir', 'GrupoController@addAlunoDir');
        Route::post('/grupo/addProfGrupo', 'GrupoController@addProfGrupo');
        Route::post('/grupo/removeAlunoGrupo', 'GrupoController@removeAlunoGrupo');
        Route::post('/grupo/discussao/delete', 'GrupoController@delDisc');
        Route::post('/grupo/pergunta/delete', 'GrupoController@delPerg');
        Route::post('/grupo/discussao', 'GrupoController@setDisc');
        Route::post('/grupo/pergunta', 'GrupoController@setPerg');
        Route::post('/grupo/material', 'GrupoController@setMat');
        Route::post('/grupo/edit', 'GrupoController@edit');
        Route::post('/grupo/sair', 'GrupoController@sair');
        Route::post('/grupo/excluir', 'GrupoController@excluir');
        //DENÃšNCIA
        Route::post('/grupo/denuncia/create', 'DenunciaController@createDenunciaGrupo');
        Route::post('/grupo/denuncia/analisa', 'DenunciaController@analisaDenunciaGrupo');
    });
});

Route::group(array('domain' => 'projeto.etecsocial.com.br'), function()
{
    //PROJETO
    Route::get('/', 'ProjetoController@index');
    //CONTATO
    Route::post('/sendmail', 'ProjetoController@sendmail');
});
