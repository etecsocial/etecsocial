@extends('base')
@section('title')
{{ $post->titulo }}
@stop

@section('style')
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/form.min.js') !!}
{!! Html::script('js/jquery.tagsinput.min.js') !!}

{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}

{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}
{!! Html::script('js/script-feed.js') !!}

@stop

@include('partials._nav')

@section('content')
    @include('post.post')
@stop
