@extends('base')
@section('title')
503 | Manutenção
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
            <h1 class="header center red-text text-darken-2">ERRO 503</h1>
            <div class="row center ">
                <h5 class="header col s12 red-text">Estamos em manutenção!</h5>
                <h6 class="header col s12 red-text">Aguarde alguns minutos e atualize a página.</h6>
            </div>
        </div>
    </div>
</div>
@stop
