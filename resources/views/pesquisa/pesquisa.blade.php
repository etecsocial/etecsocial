@extends('base')

@section('title')
{{ $termo }} - Pesquisa ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
						'/css/materialize.css',
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
            <h5 class="breadcrumbs-title">Resultados da Pesquisa</h5>
            <p>Encontrados {{ $qtd_results }} resultados para: "{{ $termo }}"</p>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col s12">
      <ul class="tabs">
         @if(isset($posts_publico[0]))
         <li class="tab col s3"><a href="#publico" class="color-sec-darken-text active">Posts Públicos</a></li>
         @endif
         @if(isset($posts_amigos[0]))
         <li class="tab col s3"><a href="#amigos" class="color-sec-darken-text">Posts de Amigos</a></li>
         @endif
         @if(isset($alunos[0]))
         <li class="tab col s3"><a href="#alunos" class="color-sec-darken-text">Alunos</a></li>
         @endif
         @if(isset($professores[0]))
         <li class="tab col s3"><a href="#professor" class="color-sec-darken-text">Professores</a></li>
         @endif
         @if(isset($grupos[0]))
         <li class="tab col s3"><a href="#grupos" class="color-sec-darken-text">Grupos</a></li>
         @endif
      </ul>
   </div>
   @if(isset($posts_publico[0]))
   <?php $posts = $posts_publico; ?>
   <div id="publico" class="col s12">
      <ul class="collection">
         @include('home.posts')
      </ul>
   </div>
   @endif
   @if(isset($posts_amigos[0]))
   <?php $posts = $posts_amigos; ?>
   <div id="amigos" class="col s12">
      <ul class="collection">
         @include('home.posts')
      </ul>
   </div>
   @endif
   @if(isset($alunos[0]))
   <div id="alunos" class="col s12">
      <ul class="collection">
         @foreach($alunos as $aluno)
         <li class="collection-item avatar">
            <img src="{{ auth()->user()->avatar($aluno->id) }}" data-tooltip="{{ $aluno->nome_usuario }}" class="circle responsive-img valign profile-image tooltipped">
            <span class="title"><a href="{{ url(auth()->user()->verUser($aluno->id)->username) }}"><strong>{{ $aluno->nome_usuario }}</strong></a></span>
            <p>{{ $aluno->nome_etec }}<br>
               {{ $aluno->sigla }}
            </p>
            <a href="{{ url(auth()->user()->verUser($aluno->id)->username) }}" class="secondary-content"><i class="material-icons color-pri-text">send</i></a>
         </li>
         @endforeach
      </ul>
   </div>
   @endif
   @if (isset($professores[0]))
   <div id="professor" class="col s12">
      <ul class="collection">
         @foreach($professores as $professor)
         <li class="collection-item avatar">
            <img src="{{ auth()->user()->avatar($professor->id) }}" data-tooltip="{{ $professor->nome_usuario }}" class="circle responsive-img valign profile-image tooltipped">
            <span class="title"><a href="{{ url(auth()->user()->verUser($professor->id)->username) }}"><strong>{{ $professor->nome }}</strong></a></span>
            <p>Professor de {{ auth()->user()->infoAcademica($professor->id)->atuacao }}<br>
               Formado em {{ auth()->user()->infoAcademica($professor->id)->formacao }}
            </p>
            <a href="#!" class="secondary-content"><i class="material-icons color-pri-text">send</i></a>
         </li>
         @endforeach
      </ul>
   </div>
   @endif
   @if (isset($grupos[0]))
   <div id="grupos" class="col s12">
      <div class="collection">
         @foreach($grupos as $grupo)
         <a class="collection-item" href="{{ url("grupo/$grupo->url") }}" class="collection-item">{{ $grupo->nome }} / {{ $grupo->assunto }}
         <span class="badge">{{$grupo->num_participantes}} 
         @if ($grupo->num_participantes == 1)
         membro
         @else
         membros
         @endif
         </span>
         </a>
         @endforeach
      </div>
   </div>
   @endif
   @if (!isset($alunos[0]) && !isset($posts_publicos[0]) && !isset($posts_amigos[0]) && !isset($professores[0]) && !isset($grupos[0]))
   <p class="col s12">Ops, parece que não encontramos nada em nosso sistema com esses termos.</p>
   @endif
</div>
</div>
</div>
</section>
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