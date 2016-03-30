<div id="material" class="tab-content col s12">

    @if(!$banido)
    @if(!isset($expirado))
    <form method="post" id="publicarMaterial" action="{{ url('ajax/grupo/material')}}" class="tab-content col s12  grey lighten-4">                                    
        <input type="hidden" name="id_grupo" value="{{ $grupo->id }}">
        <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="active">
                <div class="collapsible-header active">Endereço da web</div>
                <div class="collapsible-body" style="">

                    <div class="row">
                        <input type="hidden" name="id_grupo" value="{{ $grupo-> id}}">
                        <div class="col s2">
                            <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post" style="max-width: 100px">
                        </div>
                        <div class="input-field col s5">
                            <input name="nomeEnd" placeholder="Nome" spellcheck="true" autocomplete="off" autofocus length="50" type="text" class="validate tooltipped" data-tooltip="O titulo deve ser objetivo." data-delay="50" data-position="bottom">
                        </div>
                        <div class="input-field col s5">
                            <input name="caminho" placeholder="Endereço da web" length="25" type="text" class="validate tooltipped" data-tooltip="Caso queira, adicione um link externo." data-delay="50" data-position="bottom">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m4 share-icons">
                        </div>
                        <div class="col s12 m8 right-align">
                            <button type="submit" class="waves-effect waves-light btn color-sec-light"><i class="mdi-maps-rate-review right"></i>Publicar</button>
                        </div>
                    </div>                                                                                               
                </div>
            </li>
            <li>
                <div class="collapsible-header ">Mídia</div>
                <div class="collapsible-body" style="display: block;">
                    <div class="row">
                        <input type="hidden" name="id_grupo" value="{{ $grupo-> id}}">
                        <div class="col s2">
                            <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post" style="max-width: 100px">
                        </div>
                        <div class="input-field col s5">
                            <input name="nomeMid" placeholder="Nome" spellcheck="true" autocomplete="off" autofocus length="25" type="text" class="validate tooltipped" data-tooltip="O titulo deve ser objetivo." data-delay="50" data-position="bottom">
                        </div>

                        <div class="file-field input-field col s5">
                            <input class="file-path validate" type="text">
                            <div class="btn">
                                <span>Mídia</span>
                                <input name="midia" placeholder="Sua publicação"  type="file" class="validate tooltipped" data-tooltip="Adicione uma foto ou vídeo" data-delay="50" data-position="bottom">
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col s12 m4 share-icons">
                        </div>
                        <div class="col s12 m8 right-align">
                            <button type="submit" class="waves-effect waves-light btn color-sec-light"><i class="mdi-maps-rate-review right"></i>Publicar</button>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="collapsible-header">Documento</div>
                <div class="collapsible-body" style="">
                    <div class="row">
                        <input type="hidden" name="id_grupo" value="{{ $grupo-> id}}">
                        <div class="col s2">
                            <img src="{{ auth()->user()->myAvatar() }}" alt="" class="circle responsive-img valign profile-image-post" style="max-width: 100px">
                        </div>
                        <div class="input-field col s5">
                            <input name="nomeDoc" placeholder="Nome" spellcheck="true" autocomplete="off" autofocus length="25" type="text" class="validate tooltipped" data-tooltip="O titulo deve ser objetivo." data-delay="50" data-position="bottom">
                        </div>
                        <div class="file-field input-field col s5">
                            <input class="file-path validate" type="text">
                            <div class="btn">
                                <span>Doc </span>
                                <input name="documento" placeholder="Adicionar documento" type="file" class="validate tooltipped" data-tooltip="Ex.: Arquivos Word, Excel, Power Point, PDF etc." data-delay="50" data-position="bottom">
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col s12 m4 share-icons">
                        </div>
                        <div class="col s12 m8 right-align">
                            <button type="submit" class="waves-effect waves-light btn color-sec-light"><i class="mdi-maps-rate-review right"></i>Publicar</button>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </form>  <!-- FORM MATERIAL COMPLEMENTAR-->
    @else 
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center"> A data de expiração do grupo já passou. Não é possível publicar novos materiais, mas você ainda pode ver os que foram publicados.</li>
        </ul>
    </div>
    @endif
    @else
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center"> Você não possui permissão para publicar nesse grupo, mas ainda pode ver os materiais publicados por você.</li>
        </ul>
    </div>
    @endif
@if($banido)
        @if($materiais = App\GrupoMaterial::where('id_autor', $thisUser->id)->get())
            @foreach($materiais as $material)
            <div class="col s6">
                <ul class="collection">
                    <li class="collection-item avatar" style="height: auto">
                        <img src="{{ auth()->user()->avatar($material->id_autor) }}" data-tooltip="Este é {{ auth()->user()->verUser($material->id_autor)->nome }}" class="circle tooltipped">
                        <span class="title">Por {{ auth()->user()->verUser($material->id_autor)->nome }}</span>
                        <br>{{ $material->nome }}<p>
                            @if($material->tipo == 'link')
                            <a target="_blank" href="http://{{$material->caminho}}">Ir para "{{ $material->caminho }}"</a>
                        </p><a href="#!" class="secondary-content"><i class="material-icons">http</i></a>
                        @elseif($material->tipo == 'midia')
                        Foto - Video
                        <a  href="{{ url($material->caminho)}}" data-lightbox="joao">Visualizar</a>
                        </p><a href="#!" class="secondary-content"><i class="material-icons">perm_media</i></a>
                        @else
                        Documento
                        <a href="{{ url($material->caminho)}}">Fazer download</a>
                        </p><a href="#!" class="secondary-content"><i class="material-icons">description</i></a>
                        @endif

                    </li>
                </ul>
            </div>
            @endforeach
        @else
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-item center">Não há materiais que voce possa ver.</li>
            </ul>
        </div>
        @endif
@elseif(isset($materiais[0]))

        @foreach($materiais as $material)
            <div class="col s6">
                <ul class="collection">
                    <li class="collection-item avatar" style="height: auto">
                        <img src="{{ auth()->user()->avatar($material->id_autor) }}" data-tooltip="Este é {{ auth()->user()->verUser($material->id_autor)->nome }}" class="circle tooltipped">
                        <span class="title">Por {{ auth()->user()->verUser($material->id_autor)->nome }}</span>
                        <br>{{ $material->nome }}<p>
                            @if($material->tipo == 'link')
                            <a target="_blank" href="http://{{$material->caminho}}">Ir para "{{ $material->caminho }}"</a>
                        </p><a href="#!" class="secondary-content"><i class="material-icons">http</i></a>
                        @elseif($material->tipo == 'midia')
                        Foto - Video
                        <a  href="{{ url($material->caminho)}}" data-lightbox="joao">Visualizar</a>
                        </p><a href="#!" class="secondary-content"><i class="material-icons">perm_media</i></a>
                        @else
                        Documento
                        <a href="{{ url($material->caminho)}}">Fazer download</a>
                        </p><a target="_blank"href="#!" class="secondary-content"><i class="material-icons">description</i></a>
                        @endif

                    </li>
                </ul>
            </div>
        @endforeach

    @else 
    <div class="col s12">
        <ul class="collection with-header">
            <li class="collection-item center">
                {{ isset($expirado) ? 'Não há materiais complementares neste grupo.' : 'Ainda não há materiais complementares neste grupo. Fique à vontade para adicionar!.'}}
            </li>
        </ul>
    </div>
    @endif


</div>