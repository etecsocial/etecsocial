@extends('base')
@section('title')
Ranking | ETEC Social
@stop
@section('style')
{!! Minify::stylesheet(['/css/style.css'])->withFullURL() !!}
<style> .ranking li { padding: 25px 0; } </style>
@stop
@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
'/js/plugins/lightbox-plus-jquery.min.js',
'/materialize-css/js/materialize.min.js',
'/js/plugins/jquery.nanoscroller.min.js',
'/js/plugins/sparkline/jquery.sparkline.min.js',
'/js/plugins/sparkline/sparkline-script.js',
'/js/plugins/succinct-master/jQuery.succinct.min.js',
'/js/script.js',
'/js/plugins.js']) !!}
@stop
@section('content')
@include('partials._nav')
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
   <p class="caption">É possível conseguir pontos através de desafios feitos pelos professores! <a href="{{url('/desafios')}}">Desafios</a></p>
   <div class="divider"></div>
   <ul class="ranking">
      @foreach($usuarios as $usuario)
      <li class="row">
         <div class="col l2">
            <a href="{{ auth()->user()->avatar($usuario->user_id) }}" data-lightbox="ju">
            <img src="{{ auth()->user()->avatar($usuario->user_id) }}" alt="avatar" class="circle responsive-img valign profile-image">
            </a>
         </div>
         <div class="col l5">
            # {{ $usuario->position }}
            <a href="{{ url($usuario->user->username) }}">
               <h5>{{$usuario->user->name}}</h5>
            </a>
            <h6>{{$usuario->pontos}} pontos</h6>
         </div>
      </li>
      <div class="divider"></div>
      @endforeach
   </ul>
</div>
@stop
