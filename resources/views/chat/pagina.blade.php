@extends('app')

@section('title')
Mensagens | ETEC Social
@stop

@section('style')
{!! Html::style('css/font.css') !!}
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/firebase.js') !!}
{!! Html::script('js/form.min.js') !!}
{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/jquery.bxslider.min.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}
{!! Html::script('js/jquery.tagsinput.min.js') !!}
{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}
@stop

@section('content')
@include('nav')
