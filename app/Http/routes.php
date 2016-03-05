<?php

//Route::group(['domain' => 'etec.localhost'], function()
//{
    //AUTH
    //Route::controllers([ 
    //    'auth' => 'Auth\AuthController', 
    //    'password' => 'Auth\PasswordController'
    //]);   
 
    //HOME
    Route::get('/', 'HomeController@index');
    Route::post('/', 'HomeController@login_or_cadastro');
    Route::get('/logout', 'HomeController@logout');
    //FACEBOOK
    Route::get('/facebook_login', 'FacebookController@login');
    Route::get('/facebook_feedback', 'FacebookController@feedback');

    Route::group(['middleware' => 'auth'], function() {    
        //DESAFIO
        Route::get('/desafios', 'DesafioController@index');
        Route::get('/ranking', 'DesafioController@ranking');
        //AGENDA
        Route::get('/agenda', 'AgendaController@index');
        //PESQUISA
        Route::get('/busca/{termo}', 'PesquisaController@index');
        //GRUPO
        Route::get('/grupos', 'GrupoController@listar');
        Route::get('/grupo/{groupname}', 'GrupoController@index');
        //TAREFA
        Route::get('/tarefas', 'TarefaController@index');
        //TAGS
        Route::get('/tag/{tag}', 'TagController@show');    
        //MENSAGENS
        Route::get('/mensagens', 'ChatController@pagina');
        //POST
        Route::get('/post/{id}', 'PostController@show');
        //PERFIL
        Route::get('/{username}', 'PerfilController@index');
        Route::get('/perfil/editar', 'PerfilController@update');
    });

    //AJAX
    Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
        //CONTA
        Route::post('/config', 'ContaController@editar');
        //AGENDA
        Route::get('/agenda', 'AgendaController@api');
        Route::resource('/agenda', 'AgendaController');
        //CONTA
        Route::group(['prefix' => 'cadastro'], function () {
            Route::get('/escolas', 'ContaController@consultarEscola');
            Route::get('/turmas', 'ContaController@consultarTurma');
        });
        //MENSAGEM
        Route::group(['prefix' => 'chat'], function () {
            Route::post('/enviar', 'ChatController@enviar');
            Route::post('/abrir', 'ChatController@abrir');
            Route::post('/channel', 'ChatController@channel');
        });
         //PESQUISAR
        Route::get('/buscar', 'PesquisaController@buscaRapida');
        //STATUS
        Route::post('/status', 'PerfilController@status');
        //NEWPOST
        Route::post('/newpost', 'HomeController@newpost');
        Route::post('/perfil/newpost', 'PerfilController@newpost');
        //MOREPOST
        Route::post('/morepost', 'HomeController@morepost');
        Route::post('/perfil/morepost', 'PerfilController@morepost');
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
        Route::group(['prefix' => 'notificacao'], function () {
            Route::get('/makeread', 'NotificacaoController@makeread');
            Route::post('/new', 'NotificacaoController@newnoti');
            Route::post('/channel', 'NotificacaoController@channel');
        });
        //GRUPO
        Route::group(['prefix' => 'grupo'], function () {
            Route::post('/criar', 'GrupoController@criar');
            Route::post('/edit', 'GrupoController@edit');
            Route::post('/sair', 'GrupoController@sair');
            Route::post('/excluir', 'GrupoController@excluir');
            Route::post('/discussao', 'GrupoController@setDisc');
            Route::post('/pergunta', 'GrupoController@setPerg');
            Route::post('/material', 'GrupoController@setMat');
            Route::post('/addAlunoDir', 'GrupoController@addAlunoDir');
            Route::post('/addProfGrupo', 'GrupoController@addProfGrupo');
            Route::post('/removeAlunoGrupo', 'GrupoController@removeAlunoGrupo');
            Route::post('/discussao/delete', 'GrupoController@delDisc');
            Route::post('/pergunta/delete', 'GrupoController@delPerg');
            //DENUNCIA
            Route::post('/denuncia/create', 'DenunciaController@createDenunciaGrupo');
            Route::post('/denuncia/analisa', 'DenunciaController@analisaDenunciaGrupo');
        });
    });
//});