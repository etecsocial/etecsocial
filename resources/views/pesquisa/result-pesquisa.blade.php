@extends('app')

@section('title')
ETEC Social
@stop

@section('style')
<link href="../css/asset.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@stop

@section('jscript')
<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../js/materialize.js"></script>
<script type="text/javascript" src="../js/form.min.js"></script>
<script type="text/javascript" src="../js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src='../js/script.js'></script>
<script type="text/javascript" src="../js/plugins.js"></script>
@stop

@section('content')

@include('nav')
<!-- START CONTENT -->
<section id="content">
    <div class="container">
       
            <div id="breadcrumbs-wrapper" class=" grey lighten-3">
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <h5 class="breadcrumbs-title">Resultados da Pesquisa</h5>
                            <p>Encontrados {{ $qtd_results }} resultados para: "{{isset($termo) ? $termo : '""'}}"</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs" style="background: transparent">
                        <li class="tab col s3"><a href="#test1" class="color-sec-darken-text active">Alunos</a></li>
                        <li class="tab col s3"><a href="#test2" class="color-sec-darken-text">Professores</a></li>
                    </ul>
                </div>

                <div id="test1" class="col s12">
                    <ul class="collection">
                        
                            @if(isset($alunos))
                                @foreach($alunos as $aluno)
                            <li class="collection-item avatar">
                                        <img src="{{ App\User::avatar($aluno->id) }}" data-tooltip="{{ $aluno->nome_usuario }}" class="circle responsive-img valign profile-image tooltipped">
                                        <span class="title"><a href="{{ url(App\User::verUser($aluno->id)->username) }}"><strong>{{ $aluno->nome_usuario }}</strong></a></span>
                                    <p>{{ $aluno->nome_etec }}<br>
                                        {{ explode(' ', App\User::infoAcademica($aluno->id)->modulo)[0] }} {{ $aluno->sigla }}
                                    </p>
                                    <a href="#!" class="secondary-content"><i class="material-icons color-pri-text">send</i></a>
                                </li>
                                @endforeach
                            @endif
                            @if(!isset($alunos[0]))
                            <div class="col s12">
                                <p>Ops, parece que não encontramos nenhum aluno com o nome que você buscou!</p>
                                <p>Tente pesquisar utilizando outras palavras chave.</p>
                            </div>
                            @endif
                        
                    </ul>
                </div>
                <div id="test2" class="col s12">
                    <ul class="collection">
                        
                        @if(isset($professores[0]))
                            @foreach($professores as $professor)
                                <li class="collection-item avatar">
                                        <img src="{{ App\User::avatar($professor->id) }}" data-tooltip="{{ $professor->nome_usuario }}" class="circle responsive-img valign profile-image tooltipped">
                                        <span class="title"><a href="{{ url(App\User::verUser($professor->id)->username) }}"><strong>{{ $professor->nome }}</strong></a></span>
                                    <p>Professor de {{ App\User::infoAcademica($professor->id)->atuacao }}<br>
                                        Formado em {{ App\User::infoAcademica($professor->id)->formacao }}
                                    </p>
                                    <a href="#!" class="secondary-content"><i class="material-icons color-pri-text">send</i></a>
                                </li>
                            @endforeach
                            @else
                            <div class="col s12">
                                 <p>Ops, parece que não encontramos nenhum professor com o nome que você buscou!</p>
                                <p>Tente pesquisar utilizando outras palavras chave.</p>
                            </div>
                        @endif
                        
                    </ul>

            </div>
        </div>
        <!-- Floating Action Button -->
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large red">
                <i class="large mdi-editor-mode-edit"></i>
            </a>
            <ul>
                <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
            </ul>
        </div>
        <!-- Floating Action Button -->
    </div>
</div>
    <!--end container-->
</section>
<!-- END CONTENT -->

@include('footer')

<div id="modalExcluir" class="modal">
    <form action="" id="excluir" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Publicação</h4>
            <p>Tem certeza que deseja excluir esse post?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>

<div id="modalExcluirComentario" class="modal">
    <form action="" id="excluirComentario" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Comentario</h4>
            <p>Tem certeza que deseja excluir esse comentario?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>




<div id="modalDenuncia" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><strong>Denunciar Publição</strong></h4><li class="divider"></li>
        <p>O que está havendo?</p>

        <div class="painel">
            <div class="painelTitle" style="margin-top:15px">
                Selecione uma opção
            </div>

        </div>
        <div class="modal-footer">
            <div>
                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Denunciar</a>
            </div>
            <div><a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a></div>
        </div>
    </div>
    @stop