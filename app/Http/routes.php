<?php
Route::group(['middleware' => 'web'], function () {
    
    // auth route resource
    Route::auth();
    Route::get('/logout', 'HomeController@logout'); // custom logout

    // home
    Route::get('/', 'HomeController@index');
    Route::post('/', 'HomeController@login_or_cadastro');

    // facebook login
    Route::get('/facebook_login', 'FacebookController@login');
    Route::get('/facebook_feedback', 'FacebookController@feedback');

    // auth routes
    Route::group(['middleware' => 'auth'], function() {    
        //DESAFIO
        Route::get('/desafios', 'DesafioController@index');
        Route::group(['prefix' => 'ranking'], function() {
            Route::get('/', 'DesafioController@geral');
            Route::get('/etec', 'DesafioController@etec');
            Route::get('/turma', 'DesafioController@turma');
        }); 
        
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
        Route::get('/mensagens', 'MensagemController@index');
        //POST
        Route::get('/post/{id}', 'PostController@show');
        //PERFIL
        Route::get('/{username}', 'PerfilController@index');
        Route::get('/perfil/editar', 'PerfilController@update');
    });

    // register
    Route::group(['prefix' => '/ajax/cadastro'], function () {
        Route::get('/escolas', 'ContaController@consultarEscola');
        Route::get('/turmas', 'ContaController@consultarTurma');
    });

    //AJAX
    Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
        //CONTA
        Route::post('/config', 'ContaController@editar');
        //AGENDA
        Route::get('/agenda', 'AgendaController@api');
        Route::resource('/agenda', 'AgendaController');
        //CONTA
        
        //MENSAGEM
        Route::group(['prefix' => 'mensagem'], function () {
            Route::post('/store', 'MensagemController@store');
            Route::post('/getConversa', 'MensagemController@getConversa');
            Route::post('/delMensagem', 'MensagemController@delMensagem');
            Route::post('/delConversa', 'MensagemController@delConversa');
            Route::post('/getUsersRecents', 'MensagemController@getUsersRecents');
            Route::post('/getUsersFriends', 'MensagemController@getUsersFriends');
            Route::post('/getUsersUnreads', 'MensagemController@getUsersUnreads');
        });
        //CHATS
        Route::group(['prefix' => 'chat'], function () {
           // Route::post('/enviar', 'ChatController@enviar');
           // Route::post('/abrir', 'ChatController@abrir');
           // Route::post('/channel', 'ChatController@channel');
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
        Route::resource('/comentario/editar/post', 'ComentarioController@editar', ['except' => ['index', 'create', 'edit']]);
        Route::resource('/comentario/editar/discussao', 'ComentarioController@editarDiscussao', ['except' => ['index', 'create', 'edit']]);
        Route::resource('/comentario/relevancia/post', 'ComentarioController@relevancia', ['except' => ['index', 'create', 'edit']]);
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
            // Route::get('/makeread', 'NotificacaoController@makeread');
            // Route::post('/new', 'NotificacaoController@newnoti');
            // Route::post('/channel', 'NotificacaoController@channel');
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
});

