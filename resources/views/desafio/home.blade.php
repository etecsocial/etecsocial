@extends('base')

@section('title')
Desafios | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/style.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/form.min.js') !!}

{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}

{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}

@stop
@section('content')
@include('nav')
<div id="breadcrumbs-wrapper" class="grey lighten-3">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Desafios</h5>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Pagina Inicial</a></li>
                    <li class="active">Desafios</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@if (auth()->user()->type > 1)
    @include('desafio.professor')
@else
    @include('desafio.aluno')
@endif

@stop
