@extends('app')

@section('title')
ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
						'/css/materialize.css',
                        '/css/asset.css',
                        '/css/style.css',
                        '/js/plugins/fullcalendar/css/fullcalendar.min.css'])->withFullURL() !!}
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

{!! Html::script('js/plugins/fullcalendar/lib/jquery-ui.custom.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/lib/moment.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/js/fullcalendar.min.js') !!}
{!! Html::script('js/plugins/fullcalendar/fullcalendar-script.js') !!}

{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}
<script>
            function comentar(id_post) {
            var elem = "#comentarios-" + id_post;
                    var id_comentario = $(".com-" + id_post + ":last").data("id");
                    var comentario = document.getElementById("comentario-" + id_post).value;
                    $.ajax({
                    type: "POST",
                            url: "/ajax/comentario",
                            data: "id_post=" + id_post + "&id_comentario=" + id_comentario + "&comentario=" + comentario,
                            dataType: "json",
                            error: function (data) {
                            if (data.responseText === "empty") {
                            Materialize.toast('Digite algo para comentar.', 5000);
                                    return false
                            } else {
                            $(elem).append(data.responseText);
                                    $("#comentario-" + id_post).val('');
                            }
                            }
                    });
                    return false;
                    }

    function favoritar(id_post) {
    var elem = "#favoritar-" + id_post;
            $.ajax({
            type: "POST",
                    url: "/ajax/post/favoritar",
                    data: "id_post=" + id_post,
                    dataType: "json",
                    success: function (data) {
                    if (data.status) {
                    if (data.num === 0) {
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você favoritou"});
                    } else {
                    $(elem).removeClass("red")
                            .addClass("grey")
                            .attr({"data-tooltip": "Você e outras " + data.num + " pessoas favoritaram"});
                    }
                    } else {
                    $(elem).removeClass("grey")
                            .addClass("red")
                            .attr({"data-tooltip": data.num + " pessoas favoritaram"});
                    }
                    }
            });
            return false;
            }

    function repost(id_post) {
    $.ajax({
    type: "POST",
            url: "/ajax/repost",
            data: "id_post=" + id_post,
            dataType: "json",
            success: function (data) {
            Materialize.toast('Conteúdo compartilhado com sucesso.', 5000);
                    if (data.num === 1) {
            $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoa compartilhou"});
            } else {
            $("#repost-" + id_post).attr({"data-tooltip": data.num + " pessoas compartilharam"});
            }
            }
    });
            return false;
            }

    function excluir(id_post) {
    $("#excluir").attr({"action": "/ajax/post/" + id_post});
            }

    $('#excluir').ajaxForm({
    type: "DELETE",
            dataType: 'JSON',
            success: function (data) {
            if (data.status) {
            $('*[data-id="' + data.id + '"]').fadeOut(1000, function () {
            this.remove();
            });
            } else {
            Materialize.toast('<span>Erro ao excluir publicação</span>', 3000);
            }
            }
    });
            function excluirComentario(id_post, id_comentario) {
            $("#excluirComentario").attr({"action": "/ajax/comentario/" + id_comentario});
                    }

    $('#excluirComentario').ajaxForm({
    type: "DELETE",
            dataType: 'JSON',
            success: function (data) {
            if (data.status) {
            $('#com-' + data.id).fadeOut(1000, function () {
            this.remove();
            });
            } else {
            Materialize.toast('<span>Erro ao excluir comentário</span>', 3000);
            }
            }
    });</script>

@if(isset($id))
<script>$("#verpost").openModal(); abrirPost({{ $id }})</script>
@endif

@stop

@section('content')

@include('nav')
<section id="content">
   <div id="card-widgets" class="seaction">
      <div class="row">
         @if((!isset($posts_amigos[0])) and (!isset($posts_publicos[0])))
         <ul class="collection">
            <li class="collection-item avatar">
               <p>Nenhuma publicação com essa tag foi encontrada.</p>
               <p class="ultra-small">Tente usar outra tag semelhante</p>
            </li>
         </ul>
         @endif
         <div class="col s12" id="post">
            @foreach($posts_amigos as $post)
            <div data-id="{{ $post->id }}" class="blog post col s12 m6 l4" style="margin-top: 20px">
               <div class="card">
                  <div class="card-image waves-effect waves-block waves-light">
                     @if($post->is_imagem)
                     <a href="{{ url($post->url_midia) }}" data-lightbox="img-post-1">
                     <img src="{{ url($post->url_midia) }}">
                     </a>
                     @elseif($post->is_video)
                     <video src="{{ url($post->url_midia) }}" controls style="width: 100%;height:265px;max-height: 265px"></video>
                     @else
                     <img src="{{ url($post->url_midia) }}">
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
                     <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoas comentaram"><i class="mdi-communication-comment activator"></i></a>
                        @endif
                  </ul>
                  <div class="card-content">
                     <p class="row">
                        <span class="left">
                        @foreach(App\Tag::where('id_post', $post->id)->get() as $tag) 
                        <a href="{{ url("/tag/" . $tag->tag) }}">#{{ $tag->tag }}</a>
                        @endforeach
                        @if($post->is_repost) 
                        De <a href="{{ url(auth()->user()->verUser($post->user_repost)->username) }}">{{ auth()->user()->verUser($post->user_repost)->nome }}</a> 
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
                        <img src="{{ auth()->user()->avatar($post->id_user) }}" data-tooltip="Este é {{ $post->nome }}" class="circle responsive-img valign profile-image tooltipped">
                     </div>
                     <div class="col s6 m8"> 
                        Por <a href="{{ url($post->username) }}">{{ $post->nome }}</a>
                     </div>
                     @if(auth()->user()->id == $post->id_user) 
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
                           @if(auth()->user()->id == $comentario->id_user) 
                           <a href="#modalExcluirComentario" onclick="excluirComentario({{ $post->id }}, {{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                           @endif
                           <img src="{{ auth()->user()->avatar($comentario->id_user) }}" data-tooltip="Este é {{ auth()->user()->verUser($comentario->id_user)->nome }}" class="circle tooltipped">
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
            @endforeach
            @foreach($posts_publicos as $post)
            <div data-id="{{ $post->id }}" class="blog post col s12 m6 l4" style="margin-top: 20px">
               <div class="card">
                  <div class="card-image waves-effect waves-block waves-light">
                     @if($post->is_imagem)
                     <a href="{{ url($post->url_midia) }}" data-lightbox="img-post-1">
                     <img src="{{ url($post->url_midia) }}">
                     </a>
                     @elseif($post->is_video)
                     <video src="{{ url($post->url_midia) }}" controls style="width: 100%;height:265px;max-height: 265px"></video>
                     @else
                     <img src="{{ url($post->url_midia) }}">
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
                     <li><a id="coment-{{ $post->id }}" class="btn-floating waves-effect waves-light light-blue tooltipped" data-tooltip="{{ $post->num_comentarios }} pessoas comentaram"><i class="mdi-communication-comment activator"></i></a>
                        @endif
                  </ul>
                  <div class="card-content">
                     <p class="row">
                        <span class="left">
                        @foreach(App\Tag::where('id_post', $post->id)->get() as $tag) 
                        <a href="{{ url("/tag/" . $tag->tag) }}">#{{ $tag->tag }}</a>
                        @endforeach
                        @if($post->is_repost) 
                        De <a href="{{ url(auth()->user()->verUser($post->user_repost)->username) }}">{{ auth()->user()->verUser($post->user_repost)->nome }}</a> 
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
                        <img src="{{ auth()->user()->avatar($post->id_user) }}" data-tooltip="Este é {{ $post->nome }}" class="circle responsive-img valign profile-image tooltipped">
                     </div>
                     <div class="col s6 m8"> 
                        Por <a href="{{ url($post->username) }}">{{ $post->nome }}</a>
                     </div>
                     @if(auth()->user()->id == $post->id_user) 
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
                           @if(auth()->user()->id == $comentario->id_user) 
                           <a href="#modalExcluirComentario" onclick="excluirComentario({{ $post->id }}, {{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                           @endif
                           <img src="{{ auth()->user()->avatar($comentario->id_user) }}" data-tooltip="Este é {{ auth()->user()->verUser($comentario->id_user)->nome }}" class="circle tooltipped">
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
            @endforeach
            @if(!isset($posts_amigos[0]))
            <div data-id="0" class="post blog col s12 m6 l4" style="display:none"></div>
            @endif
         </div>
      </div>
      <div class="row" id="loader-post" style="display:none">
         <div class="col s12 m4 center" style="margin-top: 30px">
         </div>
         <div class="col s12 m4 center">
            <div class="preloader-wrapper big active" style="margin-top: 30px">
               <div class="spinner-layer spinner-blue-only">
                  <div class="circle-clipper left">
                     <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                     <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                     <div class="circle"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col s12 m4 center">
         </div>
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
</div>
@stop