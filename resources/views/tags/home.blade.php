@extends('base')

@section('title')
{{ $tag }} Tags - ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
'/css/asset.css',
'/css/style.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js',
'/materialize-css/js/materialize.min.js',
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
                <h5 class="breadcrumbs-title">Resultados da pesquisa</h5>
                Encontradas {{ ($posts->count()) }} publicações com a tag "{{ $tag }}"
                <div class="divider"></div>
                <p>Pesquisar por matérias: <a href="Matematica">#Matemática </a><a href="{{url('/tag/Portugues')}}">#Português </a><a href="{{url('/tag/Historia')}}">#História </a><a href="{{url('/tag/Geografia')}}">#Geografia </a><a href="{{url('/tag/Biologia')}}">#Biologia </a><a href="{{url('/tag/Sociologia')}}">#Sociologia </a><a href="{{url('/tag/Filosofia')}}">#Filosofia </a></p>
                <p>Assuntos em alta: <a href="CelulasTronco">#CelulasTronco </a><a href="{{url('/tag/Transgenicos')}}">#Transgênicos </a><a href="{{url('/tag/feteps2016')}}">#Feteps2016 </a></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
       @include('feed.posts')
       @if((empty($posts[0])))
        <ul class="collection with-header">
            <li class="collection-item center darken-4">Não foram encontradas publicações com a tag que você usou. Tente utilizar uma tag diferente ou utilize a barra de pesquisa para buscar o que você precisa.</li>
        </ul>       
        @endif
    </div>
</div>
@include('footer')
<div id="modalExcluir" class="modal">
    <form  id="excluir" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Publicação</h4>
            <p>Tem certeza que deseja excluir esse post?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>
<div id="modalExcluirComentario" class="modal">
    <form  id="excluirComentario" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Comentario</h4>
            <p>Tem certeza que deseja excluir esse comentario?</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div>
<div id="modalDenuncia" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><strong>Denunciar Publição</strong></h4>
        <li class="divider"></li>
        <p>O que está havendo?</p>
        <div class="painel">
            <div class="painelTitle" style="margin-top:15px">
                Selecione uma opção
            </div>
        </div>
        <div class="modal-footer">
            <div>
                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Denunciar</a>
            </div>
            <div><a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a></div>
        </div>
    </div>
    @stop

