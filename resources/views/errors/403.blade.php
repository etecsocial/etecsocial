@extends('base')
@section('title')
403 | Permissão negada
@stop

@section('style')
{!! Minify::stylesheet('/css/materialize.min.css') !!}
@stop
 @section('content')
<nav class="red darken-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="{{ url('/') }}" class="brand-logo">ETEC Social</a></div>
</nav>
<div id="index">
    <div class="no-pad-bot">
        <div class="container">
            <br>
            <br>
            <h1 class="header center red-text text-darken-2">ERRO 403</h1>
            <div class="row center ">
                <h5 class="header col s12 red-text">Ops, parece que você não tem permissão para acessar isso.</h5>
                <h6 class="header col s12 red-text">Por favor, volte para onde estava!</h6>
            </div>
            <div class="row center">
                <a href="{{ ((\Request::header('referer')) ? Request::header('referer') : url('/')) }}" id="entrar-button" class="btn-large waves-effect waves-light red lighten-1 modal-trigger">Voltar</a>
            </div>
        </div>
    </div>
</div>
@stop
