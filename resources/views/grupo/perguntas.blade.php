<div id="perguntas" class="tab-content col s12">
    @if(!$banido) @if(!isset($expirado))
    <form method="post" id="publicarPergunta" action="{{ url('ajax/grupo/pergunta')}}" class="tab-content col s12  grey lighten-4">
        <div class="row">
            <input type="hidden" name="idgrupo" value="{{ $grupo-> id}}">
            <div class="col s2">
                <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post" style="max-width:100px">
            </div>
            <div class="input-field col s10">
                <input name="assunto" placeholder="Assunto" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="Use no máximo 3 tags, sepadas por espaço." data-delay="50" data-position="bottom">
            </div>
            <div class="input-field col s10">
                <input name="pergunta" placeholder="Sua pergunta" type="text" autocomplete="off" class="validate tooltipped" data-tooltip="Procure ser objetivo. Use o icone de ajuda para macetes." data-delay="50" data-position="bottom">
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
            <li class="collection-item center"> A data de expiração do grupo já passou. Não é possível fazer novas perguntas, mas você ainda pode ver o conteúdo já publicado.</li>
        </ul>
    </div>
    @endif @else
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center"> Você não possui permissão para publicar nesse grupo, mas ainda pode ver as perguntas que fez.</li>
        </ul>
    </div>
    @endif @if(isset($perguntas[0])) @foreach($perguntas as $pergunta)
    <div class="blog col s4" style="margin-top: 20px;" id="pergunta-{{$pergunta->id}}">
        <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <a href="#!"><img src="../images/place-help.jpg" alt="Alguém perguntou algo!">
                </a>
            </div>
            <ul class="card-action-buttons">
                <li>
                    <a class="btn-floating waves-effect waves-light light-blue">
                        <i class="material-icons activator">chat</i>
                    </a>
                </li>
            </ul>
            <div class="card-content">
                <p class="row">
                    <span class="right">{{ Carbon\Carbon::createFromTimeStamp(strtotime($pergunta->created_at))->diffForHumans() }}</span>
                </p>
                <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $pergunta-> assunto}}</a>
                </h4>
                <p class="blog-post-content" style="height: 110px !important; max-height: 110px !important; overflow-y: scroll">"{{ $pergunta-> pergunta}}"</p>
                <div class="row">
                    <div class="col s2">
                        <img src="{{ auth()->user()->avatar($pergunta->autor_id) }}" alt="{{ auth()->user()->verUser($pergunta->autor_id)->nome }}." class="circle responsive-img valign profile-image">
                    </div>
                    <div class="col s8"> Por <a href="{{ url(auth()->user()->verUser($pergunta->autor_id)->username)}}">{{ auth()->user()->verUser($pergunta->autor_id)->nome }}</a></div>
                    @if((auth()->user()->id == $pergunta->autor_id) or (($integranteEu->is_admin) and (!auth()->user()->isTeacher($pergunta->autor_id))) or (auth()->user()->isTeacher(auth()->user()->id) and (App\GrupoUser::where('user_id', $pergunta->autor_id)->where('is_admin', 0)->where('grupo_id', $grupo->id))))
                    <a href="#modalExcluirPergunta" onclick="excluirPergunta({{ $pergunta-> id}})" class="wino"><i class="mdi-action-delete waves-effect waves-light " style="opacity: 0.7"></i></a> @else
                    <a href="#modalDenunciaGrupo" onclick="denunciaGrupo({{ $pergunta->id}}, 'pergunta')" class="wino"><i class="mdi-content-flag waves-effect waves-light " style="opacity: 0.7"></i></a> @endif
                </div>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4"><i class="mdi-navigation-close right"></i> Respostas</span>
                <ul class="collection" id="com-perg-{{ $pergunta->id}}" style="margin-top:15px">
                    @if($banido) @if($comments = App\ComentarioPergunta::where('id_pergunta', $pergunta->id)->where('user_id', auth()->user()->id)->get()) @foreach($comments as $comm)
                    <li id="com-perg-{{ $comm-> id}}" class="collection-item avatar com-perg-{{ $pergunta-> id}}" style="height: auto; min-height:65px" data-id="{{ $comm-> id}}">
                        <a href="#modalExcluirComentarioPergunta" onclick="excluirComentarioPergunta({{ $comm-> id}})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
                        <img src="{{ auth()->user()->avatar($comm->user_id) }}" data-tooltip="Você" class="circle tooltipped">
                        <div style="max-height: 80px; overflow: auto">
                            <p>{{ $comm->comentario}}</p>
                        </div>
                        <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comm->created_at))->diffForHumans() }}</span>
                    </li>
                    @endforeach @else
                    <p>Você não pode mais responder esta pergunta.</p>
                    @endif @elseif($comments = App\ComentarioPergunta::where('id_Pergunta', $pergunta->id)->get()) @foreach($comments as $comm)
                    <li id="com-perg-{{ $comm-> id}}" class="collection-item avatar com-perg-{{ $pergunta->id }}" style="height: auto; min-height:65px" data-id="{{ $comm->id}}">
                        @if((auth()->user()->id == $comm->user_id) or (($integranteEu->is_admin) and (!auth()->user()->isTeacher($comm->user_id))) or (auth()->user()->isTeacher(auth()->user()->id) and (App\GrupoUser::where('user_id', $comm->user_id)->where('is_admin', 0))))
                        <a href="#modalExcluirComentarioPergunta" onclick="excluirComentarioPergunta({{ $comm->id}})" class="wino"><i class="mdi-navigation-close right tiny"></i></a> @endif
                        <img src="{{ auth()->user()->avatar($comm->user_id) }}" data-tooltip="{{ auth()->user()->verUser($comm->user_id)->nome }}" class="circle tooltipped">
                        <div style="max-height: 80px; overflow: auto">
                            <p>{{ $comm-> comentario}}</p>
                        </div>
                        <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comm->created_at))->diffForHumans() }}</span>
                    </li>
                    @endforeach @else
                    <p>Ninguém respondeu à esta pergunta{{ isset($expirado) ? '.' : ' ainda. '}}</p>
                    @endif
                </ul>
                @if(!$banido) @if(!isset($expirado))
                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12">
                        <div class="input-field col s12">
                            <form method="POST" onsubmit="return responder({{ $pergunta-> id}}, {{ $grupo-> id}});">
                                <input type="hidden" name="id_pergunta" value="{{ $pergunta->id }}">
                                <input id="perg-resp-{{ $pergunta->id}}" type="text" class="validate" autocomplete="off">
                                <label for="resposta">Responder</label>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12">
                        <p style="margin-left: 10px">Não é possível responder perguntas deste grupo.</p>
                    </div>
                </div>
                @endif @else
                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12">
                        <p style="margin-left: 10px">Você não pode responder perguntas deste grupo.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach @else @if(isset($banido))
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center">{{ isset($expirado) ? 'Não há perguntas no grupo.' : 'Ainda não há perguntas nesse grupo.'}}</li>
        </ul>
    </div>
    @else
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center">Não há perguntas que você possa ver.</li>
        </ul>
    </div>
    @endif @endif
</div>