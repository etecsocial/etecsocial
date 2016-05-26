@extends('base')
@section('title') ETEC Social | Compartilhando conhecimentos @stop

@section('style')
{!! Minify::stylesheet(['/css/home.css'])->withFullUrl() !!}
@stop

@section('content') @include('home.nav')
<div id="index">
    <div class="section no-pad-bot">
        <div class="container">
            <h1 class="header center red-text text-darken-2 hide-on-med-and-down">Entre na rede com seus amigos!</h1>
            <div class="row center">
                <h5 class="header col s12 red-text">Compartilhe conhecimentos juntos e desafie seus amigos!</h5>
            </div>
            <div class="row center">
                <a href="#login" id="entrar-button" class="modal-trigger btn-large waves-effect waves-light red lighten-1 modal-trigger"><i class="material-icons left">input</i>Entrar</a>
                <a href="#register" id="cadastrar-button" class="modal-trigger btn-large waves-effect waves-light red darken-2 modal-trigger"><i class="material-icons left">person_pin</i>Cadastrar-se</a>
            </div>
        </div>
    </div>
</div>
<div class="container" id="site-features">
    <div class="section">
        <div class="row">
            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">flash_on</i></h2>
                    <h5 class="center">Grupos de Estudos</h5>
                    <p class="text-justify">Ao se aproximar da semana de provas, alunos poderão criar grupos de estudo sobre determinada disciplina. Tal grupo terá um local que sugerirá fontes de estudo sobre a matéria, além de ser possível realizar desafios aos membros destes grupos.</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">group</i></h2>
                    <h5 class="center">Agenda de Estudos</h5>
                    <p class="text-justify">A Agenda de estudos será uma ferramenta que possibilitará o agendamento de provas, trabalhos e apresentações tanto pelo professor quanto pelo aluno. O sistema então irá sugerir a criação de grupos de estudos para auxiliar o aluno.</p>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">settings</i></h2>
                    <h5 class="center">Desafios</h5>
                    <p class="text-justify">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12">
                <div class="video-container">
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/pAfiLcMJ7q8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@include('home.footer') @stop