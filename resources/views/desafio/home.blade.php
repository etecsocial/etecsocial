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
<div class="container">
    <p class="caption">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
    <div class="divider"></div>
    <div id="borderless-table">
        <h4 class="header">Desafios por matéria</h4>
        <div class="row">
            <div class="col s12 m12 l12">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Matéria</th>
                            <th>Professor</th>
                            <th>Pontuação (+)</th>
                            <th>Finaliza em: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">Qual a sequência?</a></td>
                            <td>Matemática</td>
                            <td>Bordignon</td>
                            <td>+ 900 pontos</td>
                            <td>22/04/2016</td>
                        </tr>
                        <tr>
                            <td><a href="#">Desenha uma célula</a></td>
                            <td>Biologia</td>
                            <td>Alex</td>
                            <td>+ 900 pontos</td>
                            <td>22/04/2016</td>
                        </tr>
                        <tr>
                            <td><a href="#">Resumo Guerra em Paz em 1 folha</a></td>
                            <td>Português</td>
                            <td>Roberta</td>
                            <td>+ 900 pontos</td>
                            <td>22/04/2016</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
