@extends('app')

@section('title')
Ranking | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/asset.css',
                        '/css/style.css'])->withFullURL() !!}
@stop
@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
                        '/js/plugins/lightbox-plus-jquery.min.js',
                        '/js/materialize.js',
                        '/js/form.min.js',
                        '/js/script.js',
                        '/js/plugins.js']) !!}
@stop
@section('content')
@include('nav')
<div id="breadcrumbs-wrapper" class="grey lighten-3">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">{{ $tipo }}</h5>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Pagina Inicial</a></li>
                    <li><a href="{{ url('/desafios') }}">Desafios</a></li>
                    <li><a href="{{ url('/ranking') }}">Ranking</a></li>
                    <li class="active">{{ $tipo }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
	<p class="caption">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
 	<div class="divider"></div>
<style>
.ranking li {
	padding: 25px 0;
}
</style>
 	<ul class="ranking">
 		@foreach($usuarios as $usuario)
        <li class="row">
 			<div class="col l2">
 				<a href="{{ App\User::avatar($usuario->user_id) }}" data-lightbox="ju">
                	<img src="{{ App\User::avatar($usuario->user_id) }}" alt="avatar" class="circle responsive-img valign profile-image">
            	</a>
            </div>
            <div class="col l5">
                #1
            	<a href="{{ url($usuario->username) }}">
                    <h4>{{$usuario->nome}}</h4>
                </a>
            	<h6>{{$usuario->pontos}} pontos</h6>
            </div>
 		</li>

 		<div class="divider"></div>
 		@endforeach

 	</ul> 
</div>