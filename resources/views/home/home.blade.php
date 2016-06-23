@extends('base')
@section('title') ETEC Social | Compartilhando conhecimentos @stop

@section('style')
{!! Minify::stylesheet(['/css/home.css'])->withFullUrl() !!}
@stop

@section('content') 
@include('home._nav')
<div id="index">
    <nav class="white accent-2" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="{{ url('/') }}" class="brand-logo">
                <img src="{{ url('/images/logo.png') }}" alt="ETEC Social" class="logo-img">
            </a>
            <ul class="right hide-on-med-and-down">
                <li><a href="#sobre" class="modal-trigger">Sobre</a></li>
                <li><a href="#termos" class="modal-trigger">Termos</a></li>
                <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
                <li><a href="#login" class="modal-trigger"><i class="material-icons left">input</i>Entrar</a></li>

            </ul>
            <ul id="nav-mobile" class="side-nav">
                <li><a href="#entrar" class="modal-trigger">Entrar</a></li>
                <li><a href="#modal-cadastrar" class="modal-trigger">Cadastrar</a></li>
                <li>
                    <div class="divider"></div>
                </li>
                <li><a href="#sobre" class="modal-trigger">Sobre</a></li>
                <li><a href="#termos" class="modal-trigger">Termos</a></li>
                <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <div class="section no-pad-bot">
        <div class="container" style="padding-top: 100px">
            <h2 class="header center white-text text-darken-2 hide-on-med-and-down">Conecte-se com a gente.</h2>
            <div class="row center">
                <h5 class="header col s12 white-text">Porque aprender nunca foi tão divertido!</h5>
            </div>
            <div class="row center" style="margin-top: 50px">
<!--                <a href="#login" id="entrar-button" class="modal-trigger btn-large waves-effect waves-light red lighten-1 modal-trigger"><i class="material-icons left">input</i>Entrar</a>-->
                <button data-target="modal1" class="btn btn-large waves-effect waves-light red modal-trigger"><i class="material-icons left">person_pin</i>Conectar agora!</button>
            </div>

            <div class="row center" style="margin-top: 110px">
                <h5 class="white-text  thin" style="margin-bottom: 30px">Não acredita? Deixe-me apresentar.<h5>
                        <a id="btn-scroll" href="#recursos" class="lala btn-floating btn-large waves-effect waves-light  blue accent-2"><i class="mdi-hardware-keyboard-arrow-down"></i></a>
                        </div>

                        <!-- Modal Structure -->
                        <div id="modal1" class="modal singup">
                            <div class="modal-content">
                                <h4>Criar conta</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <ul class="tabs">
                                            <li class="tab col s3"><a class="1" href="#1">Aluno</a></li>
                                            <li class="tab col s3"><a class="2" href="#2">Professor</a></li>
                                            <li class="tab col s3"><a class="3" href="#3">Coordenador</a></li>
                                        </ul>
                                    </div>
                                    @include('auth.register._register-form')
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="homepage-hero-module" id="recursos">

                            <div class="video-container">

                                <div class="filter"></div>
                                <video autoplay loop class="fillWidth">
                                    <source src="{{ url('/videos/video-home/MP4/White-Board.mp4') }}" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.
                                    <source src="{{ url('/videos/video-home/WEBM/White-Board.webm') }}" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.
                                </video>
                                <div class="poster hidden">

                                    <img src="PATH_TO_JPEG" alt="">
                                </div>
                                <div class="content-video">
                                    
                                    <h1 class="white-text">Olá mundo!</h1>
                                    <h2 class="white-text thin">Ainda estou trabalhando nisso.</h2>

                                </div>
                                                                    <a id="btn-scroll" href="#recursos" class="btn-next btn-floating btn-large waves-effect waves-light  blue accent-2"><i class="mdi-hardware-keyboard-arrow-down"></i></a>


                            </div>
                        </div>
                        <!--<div class="container" id="recursos">
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
                        </div>-->
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
                        @include('home._footer') @stop