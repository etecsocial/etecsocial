@extends('app')

@section('title')
Ranking | ETEC Social
@stop

@section('style')
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
{!! Html::style('js/plugins/fullcalendar/css/fullcalendar.min.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/form.min.js') !!}

{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/jquery.bxslider.min.js') !!}
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
                <h5 class="breadcrumbs-title">Ranking</h5>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}">Pagina Inicial</a></li>
                    <li><a href="{{ url('/') }}">Desafios</a></li>
                    <li class="active">Ranking</li>
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
 		<li class="row">
 			<div class="col l2">
 				<a href="">
                	<img src="/midia/avatar/c4ca4238a0b923820dcc509a6f75849b.jpg" alt="" class="circle responsive-img valign profile-image">
            	</a>
            </div>
            <div class="col l5">
            	<h4>#1 Eduardo Ramos</h4>
            	<h5>3 ° EMIA</h5>
            	<h6>4242 pontos</h6>
            </div>
 		</li>

 		<div class="divider"></div>
 		<li class="row">
 			<div class="col l2">
 				<a href="">
                	<img src="/midia/avatar/d67d8ab4f4c10bf22aa353e27879133c.jpg" alt="" class="circle responsive-img valign profile-image">
            	</a>
            </div>
            <div class="col l5">
            	<h4>#2 John Doe</h4>
            	<h5>3 ° EMIA</h5>
            	<h6>3020 pontos</h6>
            </div>
 		</li>
 		<div class="divider"></div>
 		<li class="row">
 			<div class="col l2">
 				<a href="">
                	<img src="/midia/avatar/c4ca4238a0b923820dcc509a6f75849b.jpg" alt="" class="circle responsive-img valign profile-image">
            	</a>
            </div>
            <div class="col l5">
            	<h4>#3 Eduardo Ramos</h4>
            	<h5>3 ° EMIA</h5>
            	<h6>2000 pontos</h6>
            </div>
 		</li>

 	</ul> 
</div>