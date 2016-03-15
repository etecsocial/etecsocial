<div id="discussoes" class="tab-content col s12">
    @if(!$banido)
    @if(!isset($expirado))
    <form method="post" id="publicarDiscussao" action="{{ url('ajax/grupo/discussao')}}" class="tab-content col s12  grey lighten-4">
        <div class="row">
            <input type="hidden" name="idgrupo" value="{{ $grupo-> id}}">
            <div class="col s2">
                <img src="{{ App\User::myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post" style="max-width:100px">
            </div>
            <div class="input-field col s5">
                <input name="titulo" placeholder="Título" spellcheck="true" autocomplete="off" type="text" class="validate tooltipped" data-tooltip="O título deve ser objetivo." data-delay="50" data-position="bottom">
            </div>
            <div class="input-field col s5">
                <input name="assunto" placeholder="Assunto" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="O assunto deve ser coerente" data-delay="50" data-position="bottom">
            </div>
            <div class="input-field col s10">
                <input name="discussao" placeholder="Discussão" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="Procure ser objetivo. Não fuja do tema do grupo." data-delay="50" data-position="bottom">
            </div>
        </div>
        <div class="row">
            <div class="col s12 m4 share-icons">
            </div>
            <div class="col s12 m8 right-align">
                <button type="submit" class="waves-effect waves-light btn red"><i class="mdi-maps-rate-review right"></i>Publicar</button>
            </div>
        </div>
    </form>
    @else 
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center"> A data de expiração do grupo já passou. Não é possível criar novas discussões, mas você ainda pode ver o conteúdo já publicado.</li>
        </ul>
    </div>
    @endif
    @else <!-- (É BANIDO)-->
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center"> Você não possui permissão para publicar nesse grupo, mas ainda pode ver as discussões que criou.</li>
        </ul>
    </div>
    @endif

    <!--/ INICIO HISTÓRIA -->
    <!-- Inicio Publicação com foto ou video-->
    @if(isset($discussoes[0]))
    @foreach($discussoes as $discussao)
    <section class="discussao blog col s12" style="margin-top: 30px" id="discussao-{{$discussao->id}}" data-id='{{$discussao->id}}'>

        <div class="blog col s12 m6 l6" style="margin-top: 5px">
            <div class="card">
                <div class="card-content">

                    <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $discussao-> titulo}}</a></h4>
                    <p class="row">
                        <span class="left">{{ $discussao-> assunto}}</span>
                    </p>
                    <blockquote style="border-color:#0097a7">
                        <div style="height: auto;max-height: 300px; overflow:auto">
                            <p class="blog-post-content" style="padding-right: 10px">{{ $discussao-> discussao}}</p>
                        </div>
                    </blockquote>
                    <div class="row">
                        <div class="col s2">
                            <img src="{{ App\User::avatar($discussao->id_autor)}}" alt="Este é {{ App\User::verUser($discussao->id_autor)->nome }}." class="circle responsive-img valign profile-image">
                        </div>
                        <div class="col s9">
                            Por <a href="{{ url(App\User::verUser($discussao-> id_autor)-> username)}}">{{ App\User::verUser($discussao->id_autor)->nome }}</a>
                        </div>

                        @if((Auth::user()->id == $discussao->id_autor) or (($integranteEu->is_admin) and (!App\User::isTeacher($discussao->id_autor))) or (App\User::isTeacher(Auth::user()->id) and (App\GrupoUsuario::where('id_user', $discussao->id_autor)->where('is_admin', 0)->where('id_grupo', $grupo->id))))
                        <a href="#modalExcluirDiscussao" onclick="excluirDiscussao({{ $discussao-> id}})" class="wino"><i class="mdi-action-delete waves-effect waves-light " style="opacity: 0.7"></i></a>                                                                
                        @else
                        <a href="#modalDenunciaGrupo" onclick="denunciaGrupo({{ $discussao->id}}, 'discussao', {{ $discussao->id_autor }})" class="wino"><i class="mdi-content-flag waves-effect waves-light " style="opacity: 0.7"></i></a>                                                                
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="col s1"><i class="mdi-hardware-keyboard-arrow-right center medium hide-on-med-and-down" style="margin-top:200px; opacity: 0.5"></i></div>

        <!--DISCUSSÃO POST ("comentários") aqui-->
        <div class="card-reveal" style="height: auto; min-height: 80px;">                                            
            <span class="card-title grey-text text-darken-4"> Discussões</span>
            <div class="collection">
                <ul class="collection"  style="margin-top:0px;margin-bottom: 0;max-height: 420px;overflow-y: scroll" id="com-disc-{{ $discussao-> id}}">

                    @if($banido)
                    @if($comments = App\ComentarioDiscussao::where('id_discussao', $discussao->id)->where('id_user', Auth::user()->id)->get())
                    @foreach($comments as $comm)
                    <li id="com-disc-{{ $comm-> id}}" class="collection-item avatar com-disc-{{ $discussao-> id}}" style="height: auto; min-height:65px" data-id="{{ $comm-> id}}">
                        <a href="#modalExcluirComentarioDiscussao" onclick="excluirComentarioDiscussao({{ $comm-> id}})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                        <img src="{{ App\User::avatar($comm->id_user) }}" data-tooltip="Este é você" class="circle tooltipped">
                        <div style="max-height: 80px; overflow-y: auto">
                            <p>{{ $comm-> comentario}}</p>
                        </div>
                        <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comm->created_at))->diffForHumans() }}</span>
                    </li>
                    @endforeach   
                    @else
                    Você não pode mais participar dessa discussão.
                    @endif
                    @elseif($comments = App\ComentarioDiscussao::where('id_discussao', $discussao->id)->get()) <!--NÃO É BANIDO-->
                    @foreach($comments as $comm)
                    <li id="com-disc-{{ $comm-> id}}" class="collection-item avatar com-disc-{{ $discussao-> id}}" style="height: auto; min-height:65px" data-id="{{ $comm-> id}}">
                        @if((Auth::user()->id == $comm->id_user) or (($integranteEu->is_admin) and (!App\User::isTeacher($comm->id_user)))) 

                        <a href="#modalExcluirComentarioDiscussao" onclick="excluirComentarioDiscussao({{ $comm-> id}})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                        @endif
                        <img src="{{ App\User::avatar($comm->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comm->id_user)->nome }}" class="circle tooltipped">
                        <div style="max-height: 80px; overflow-y: auto">
                            <p>{{ $comm-> comentario}}</p>
                        </div>
                        <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comm->created_at))->diffForHumans() }}</span>
                    </li>
                    @endforeach   
                    @else <!--NÃO ENCONTROU DISCUSSOES-->
                    Essa discussão ainda está vazia. {{ isset($expirado) ? 'Não e possível participar disso.' : 'Comece agora! '}}
                    @endif                                                

                </ul>
                @if((!$banido) and (!isset($expirado)))
                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12">
                        <div class="input-field col s12">
                            <form method="POST" onsubmit="return discutir({{ $discussao-> id}}, {{ $grupo-> id}});" >
                                <input type="hidden" name="id_post" value="{{ $discussao-> id}}" >
                                <input id="comentario-{{ $discussao-> id}}" type="text" class="validate" autocomplete="off">
                                <label for="comment" >Discutir</label>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12" style="margin-left: 10px">
                        <p style="margin-left: 10px">  Você não pode participar de discussões neste grupo.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </section>
    @endforeach
    @else
    @if(isset($banido))

    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center">{{ isset($expirado) ? 'N' : 'Ainda n' }}ão há discussões nesse grupo.</li>
        </ul>
    </div>
    @else
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center">Não há discussoes que você possa ver.</li>
        </ul>
    </div>
    @endif
    @endif

    <!-- Fim Publicação com foto ou video-->
    <!--/ FIM HISTÓRIA -->
</div>