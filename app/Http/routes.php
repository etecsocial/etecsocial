<?php

Route::group(['middleware' => 'web'], function () {
    // auth route resource
    Route::auth();

    // home
    Route::get('/', 'HomeController@index');

    // register
    Route::group(['prefix' => '/ajax/cadastro'], function () {
        Route::get('/getEscolas', 'ContaController@consultarEscola');
        Route::get('/getTurmas', 'ContaController@getTurmas');
        Route::get('/getTurmasProfDisp', 'ContaController@getTurmasProfDisp');
        Route::get('/getModulos', 'ContaController@getModulos');
        Route::get('/setTurmasProfessor', 'ContaController@setTurmaProfessor');
        Route::post('/doneTurmasCoord', 'ContaController@doneTurmas');
        Route::post('/setTurmasCoordenador', 'ContaController@setTurmas');
    });

    // social login
    // Route::get('/login/{provider}', 'SocialLoginController@login')->where('provider', '(facebook)');
    // Route::get('/fallback/{provider}', 'SocialLoginController@fallback')->where('provider', '(facebook)');

    // confirm email
    Route::get('/confirm/verify/{confirm_code}', 'ContaController@confirmEmail');

    // auth routes
    Route::group(['middleware' => 'auth'], function() {
        //DESAFIO
        Route::get('/desafios', 'DesafioController@index');
        Route::get('/desafios/{id}', 'DesafioController@show')->where('id', '[0-9-]+');
        Route::get('/desafios/create', 'DesafioController@showForm');
        Route::post('/desafios/store', 'DesafioController@store');
        Route::get('/desafios/edit', 'DesafioController@edit');
        Route::get('/desafios/edit/{id}', 'DesafioController@editForm')->where('id', '[0-9-]+');
        Route::get('/desafios/delete/{id}', 'DesafioController@delete')->where('id', '[0-9-]+');
        Route::get('/desafios/respostas/{desafio_id}', 'DesafioController@corrigirRespostas')->where('id', '[0-9-]+');
        Route::post('/desafios/respostas', 'DesafioController@corrigirResposta');


        Route::post('/desafios/responder', 'DesafioController@responder');
        Route::get('/desafios/responder/{id}', 'DesafioController@responderForm')->where('id', '[0-9-]+');

        Route::group(['prefix' => 'ranking'], function() {
            Route::get('/', 'RankingController@geral');
            Route::get('/etec', 'RankingController@etec');
            Route::get('/turma', 'RankingController@turma');
        });

        //AGENDA
        Route::get('/agenda', 'EventoController@index');
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

    //AJAX
    Route::group(['prefix' => 'ajax', 'middleware' => 'auth'], function () {
        //CONTA
        Route::post('/config', 'ContaController@editar');
        Route::post('/professor', 'ContaController@professor');
        Route::post('/aluno', 'ContaController@aluno');

        //CHATS
        Route::group(['prefix' => 'chat'], function () {
           Route::post('/enviar', 'ChatController@enviar');
           Route::post('/abrir', 'ChatController@abrir');
        });

        //EVENTO
        Route::resource('/evento', 'EventoController');

        //MENSAGEM
        Route::group(['prefix' => 'mensagem'], function () {
            Route::post('/store', 'MensagemController@store');
            Route::post('/getConversa', 'MensagemController@getConversa');
            Route::post('/getConversaArchives', 'MensagemController@getConversaArchives');
            Route::post('/delMensagem', 'MensagemController@delMensagem');
            Route::post('/delConversa', 'MensagemController@delConversa');
            Route::post('/delConversaArquivada', 'MensagemController@delConversaArquivada');
            Route::post('/getUsersRecents', 'MensagemController@getUsersRecents');
            Route::post('/getUsersFriends', 'MensagemController@getUsersFriends');
            Route::post('/getUsersUnreads', 'MensagemController@getUsersUnreads');
            Route::post('/getUsersArchives', 'MensagemController@getUsersArchives');
            Route::post('/desarquivarMensagem', 'MensagemController@desarquivarMensagem');
            Route::post('/arquivarMensagem', 'MensagemController@arquivarMensagem');
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
        Route::resource('/comentario', 'ComentarioController', [
            'except' => ['index', 'create', 'edit']
        ]);
        Route::resource('/comentario/editar/post', 'ComentarioController@editar', [
            'except' => ['index', 'create', 'edit']
        ]);
        Route::resource('/comentario/editar/discussao', 'ComentarioController@editarDiscussao', [
            'except' => ['index', 'create', 'edit']
        ]);
        Route::resource('/comentario/relevancia/post', 'ComentarioController@relevancia', [
            'except' => ['index', 'create', 'edit']
        ]);
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
        //NOTIFICACAO
        Route::group(['prefix' => 'notificacao'], function () {
             Route::get('/makeread', 'NotificacaoController@makeread');
             Route::post('/new', 'NotificacaoController@newnoti');
        });
        //GRUPO
        Route::group(['prefix' => 'grupo'], function () {
            Route::post('/criar', 'GrupoController@criar');
            Route::post('/edit', 'GrupoController@edit');
            Route::post('/sair', 'GrupoController@sair');
            Route::post('/discussao/delete', 'GrupoController@delDisc');
            Route::post('/pergunta/delete', 'GrupoController@delPerg');
            Route::post('/removeAlunoGrupo', 'GrupoController@removeAlunoGrupo');
            Route::post('/excluir', 'GrupoController@excluir');
            Route::post('/discussao', 'GrupoController@setDisc');
            Route::post('/pergunta', 'GrupoController@setPerg');
            Route::post('/material', 'GrupoController@setMat');
            Route::post('/addAlunoDir', 'GrupoController@addAlunoDir');
            Route::post('/addProfGrupo', 'GrupoController@addProfGrupo');
            //DENUNCIA
            Route::post('/denuncia/create', 'DenunciaController@createDenunciaGrupo');
            Route::post('/denuncia/analisa', 'DenunciaController@analisaDenunciaGrupo');
        });
    });
});
