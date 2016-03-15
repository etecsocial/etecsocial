@extends('app')
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
{!! Html::script('js/plugins/jquery.bxslider.min.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}

{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}

@stop

@include('nav')

@if(isset($post))
@section('content')
<div data-id="{{ $post->id }}" class="blog col s12 m6 l4" style="width: 100%">
    <div class="card">
        <div class="card-image waves-effect waves-block waves-light">
            @if($post->is_imagem)
            <a href="{{ url($post->url_midia) }}" data-lightbox="img-post-1">
                <img src="{{ url($post->url_midia) }}">
            </a>
            @elseif($post->is_video)
            <video src="{{ url($post->url_midia) }}" controls style="width: 100%;height:265px;max-height: 265px"></video>      
            @else
            <img src="{{ url($post->url_midia) }}" style="width: auto">
            @endif
        </div>
        <ul class="card-action-buttons">
            @if(App\Post::favoritou($post->id))
            @if($post->num_favoritos == 1)
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você favoritou"><i class="mdi-action-favorite-outline"></i></a>
            </li>
            @else
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light grey tooltipped" data-tooltip="Você e outras {{ $post->num_favoritos - 1 }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a>
                @endif
                @else
            <li><a id="favoritar-{{ $post->id }}" onclick="favoritar({{ $post->id }})" class="btn-floating waves-effect waves-light red tooltipped" data-tooltip="{{ $post->num_favoritos }} pessoas favoritaram"><i class="mdi-action-favorite-outline"></i></a>
            </li>
            @endif
            @if($post->num_reposts == 1)
            <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoa compartilhou"><i class="mdi-social-share"></i></a></li>
            @else
            <li><a id="repost-{{ $post->id }}" onclick="repost({{ $post->id }})" class="btn-floating waves-effect waves-light green accent-4 tooltipped" data-postid="{{ $post->id }}" data-tooltip="{{ $post->num_reposts }} pessoas compartilharam"><i class="mdi-social-share"></i></a></li>
            @endif
            @if($post->num_comentarios == 1)
            <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoa comentou"><i class="mdi-communication-comment activator"></i></a>
            </li>
            @else
            <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} comentários"><i class="mdi-communication-comment activator"></i></a>
                @endif
        </ul>
        <div class="card-content">
            <p class="row">
                <span class="left">
                    @foreach(App\Tag::where('id_post', $post->id)->get() as $tag) 
                    <a href="{{ url("/tag/" . $tag->tag) }}">#{{ $tag->tag }}</a>
                    @endforeach

                    @if($post->is_repost) 
                    De <a href="{{ url(App\User::verUser($post->user_repost)->username) }}">{{ App\User::verUser($post->user_repost)->nome }}</a> 
                    @endif
                </span>
                <span class="right">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</span>
            </p>
            <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $post->titulo }}</a>
            </h4>
            <p class="blog-post-content">{{ $post->publicacao }}</p>
        </div>
        <div class="row" id="autor-post">
            <div class="col s2">
                <img src="{{ App\User::avatar($post->id_user) }}" data-tooltip="Este é {{ $post->nome }}" class="circle responsive-img valign profile-image tooltipped">
            </div>
            <div class="col s6 m8"> 
                Por <a href="{{ url($post->username) }}">{{ $post->nome }}</a><br>
                {{ App\User::infoAcademica($post->id_user)->instituicao }}<br>
            </div>
            @if(Auth::user()->id == $post->id_user) 
            <a href="#modalExcluir" onclick="excluir({{ $post->id }})" class="wino"><i class="material-icons dropdown-button waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Excluir Publicação" data-delay="50" data-position="bottom">close</i></a>
            @else 
            <a href="#modalDenuncia" class="wino"><i class="material-icons dropdown-button waves-effect waves-light tooltipped" style="opacity: 0.7" data-tooltip="Denunciar usuário" data-delay="50" data-position="bottom">turned_in</i></a>
            @endif
        </div>
        <div class="card-reveal">                                            
            <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Comentários</span>
            <ul class="collection" id="comentarios-{{ $post->id }}" style="margin-top:15px">
                @foreach(App\Comentario::where('id_post', $post->id)->get() as $comentario)
                <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $post->id }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">

                    @if(Auth::user()->id == $comentario->id_user) 
                        @endif
                    <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
                    <p>{{ $comentario->comentario }}</p>
                </li>
                @endforeach
            </ul>
            <div class="left row white" style="height: auto; bottom: 0px; width: 90%;">
                <div class="col s12">
                    <div class="input-field col s12">
                        <form method="POST" >
                            <input type="hidden" name="id_post" value="{{ $post->id }}" >
                            <input id="comentario-{{ $post->id }}" type="text" class="validate" autocomplete="off">
                            <label for="comment" >Comentar</label>
                            <button type="submit" onclick="return comentar({{ $post->id }});" class="waves-effect waves-light btn red">Comentar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<center><h5>Lamentamos, esse post não existe ou foi excluído.</h5></center>
@endif
@stop