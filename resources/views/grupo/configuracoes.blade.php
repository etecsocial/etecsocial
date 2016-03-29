                            
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                               @if($integranteEu->is_admin)
                                @if(!isset($expirado))
                                 <li>
                                     <div class="collapsible-header" style="opacity: 0.8"><i class="mdi-action-settings"></i> Configurações</div>
                                     <div class="collapsible-body" style="padding-left: 20px">
                                         <form method="post" id="editGrupo" action="{{ url('ajax/grupo/edit')}}" >

                                             <h6 class="title">Editar grupo</h6>
                                             <div class="divider"></div>
                                             <div class="input-field col s6">
                                                 <input value="{{ $grupo->nome}}" id="name2" type="text" name="nome">
                                                 <label for="first_name" class="active">Nome</label>
                                             </div>
                                             <div class="input-field col s6">
                                                 <input type="date" class="datepicker" placeholder="Data" name="expiracao" id="expiracao_grupo">
                                                 <label for="expiracao_grupo" class="active">Expiração</label>
                                             </div>
                                             <div class="input-field col s6">
                                                 <input value="{{ $grupo->assunto}}" type="text" placeholder="Assunto" name="assunto" id="assunto_grupo">
                                                 <label for="assunto_grupo" class="active">Assunto</label>
                                             </div>
                                             <div class="input-field col s6">
                                                 <input value="{{ $grupo->url}}" type="text" placeholder="URL do grupo" name="url" id="url_grupo">
                                                 <label for="url_grupo" class="active">Url</label>
                                             </div>
                                             <div class="col s12">
                                                 <input type="hidden" name="idgrupo" value="{{ $grupo->id}}">
                                                 <a href="#modalExcluirGrupo" class="modal-trigger btn waves-effect waves-light red darken-2 col s5"><i class="mdi-action-delete left"></i>Excluir Grupo</a>
                                                 <button type="submit" title="Salvar alterações" class="btn waves-effect waves-light cyan darken-2 col s5" style="float:right"><i class="mdi-navigation-check left"></i>Salvar</button>
                                             </div>
                                             &nbsp;
                                         </form>
                                     </div>
                                 </li>
                                 @endif
                                @endif
                                <li>
                                    <div class="collapsible-header" style="opacity: 0.8"><i class="mdi-social-school"></i> Alunos no grupo</div>
                                    <div class="collapsible-body">
                                        <div class="row">
                                            <div class="col s12" style="padding-top: 10px">
                                                <div class="col s12" style="max-height: 250px;overflow-y: auto">
                                                    @if(isset($alunos_int[0]) and isset($alunos_int[1])) 
                                                        @foreach($alunos_int as $aluno)
                                                        <div id="aluno-int-1-{{$aluno->id}}">
                                                            @if($aluno->id == $thisUser->id)
                                                                <div class="col s2"><img src="{{ App\User::avatar($aluno->id) }}" alt="Este é você." data-tooltip="Você" data-delay="50" data-position="bottom" class="tooltipped circle responsive-img valign profile-image"></div>
                                                            @else   
                                                                <div class="col s2"><img src="{{ App\User::avatar($aluno->id) }}" alt="{{ App\User::verUser($aluno->id)->nome }}" data-tooltip="{{ App\User::verUser($aluno->id)->nome }}" data-delay="50" data-position="bottom" class="tooltipped circle responsive-img valign profile-image"></div>
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    @else
                                                    <p class="col s12" style="margin-bottom: 15px" id="group-alone">Você está sozinho aqui. {{ isset($expirado) ? 'Não é possível adicionar amigos.' : 'Convide amigos para participar!' }}</p>
                                                    @endif
                                                    
                                                </div>
                                                @if(!isset($expirado))
                                                @if(!$banido)
                                                    <div id="alunos-add-rec" style="display: none">
                                                        <div class="col s12">
                                                            Adicionados recentemente por você
                                                            <div class="divider" style="margin-bottom: 5px"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                    
                                                        <div class="col s12">
                                                            <div class="divider"></div>
                                                            <div class="input-field col {{$integranteEu->is_admin ? 's6' : 's12'}}">
                                                                <input id="adc-aluno-dir" placeholder="Selecione o nome" id="novo-usuario-grupo" type="text">

                                                                <label for="novo-usuario-grupo" class="active">Adicionar Aluno</label>
                                                            </div>
                                                            @if($integranteEu->is_admin)
                                                                <div class="input-field col s6">
                                                                    <input id="remove-aluno-dir" placeholder="Selecione o nome" id="novo-usuario-grupo" type="text">
                                                                    <label for="novo-remove-grupo" class="active">Banir Aluno</label>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div id="adc-alunos-dir" style="display: none;">
                                                            <ul class="collection" style="width:100%;margin-top:0!important;margin-bottom: 0!important;">
                                                                <li class="collection-item" id="amigos-grupo">
                                                                    @if(isset($amigos_nao_int))
                                                                    
                                                                        @foreach($amigos_nao_int as $amigo)
                                                                        @if(!App\User::isTeacher($amigo->id))
                                                                            <div id="grupo-amigo-dir-{{ $amigo->id }}" class="chip" onclick="addAlunoGrupoDireto({{ $amigo->id }}, {{ $grupo->id }})" style="margin-bottom: 10px; margin-right: 5px; cursor: pointer">
                                                                                <img src="{{ App\User::Avatar($amigo->id) }}" alt="Foto de {{ $amigo->nome }}">
                                                                                {{ $amigo->nome }}
                                                                                <input id="input-grupo-amigo-{{ $amigo->id }}" type="hidden" name="id_aluno" value="{{ $amigo->nome }}">
                                                                            </div>
                                                                        @endif
                                                                        @endforeach
                                                                        <div class="divider"></div>
                                                                        @elseif(isset($alunos_ban))
                                                                            <p>Alunos banidos</p><br>
                                                                            @foreach($lunos_ban as $amigo)
                                                                                <div id="grupo-amigo-dir-{{ $amigo->id }}" class="chip" onclick="addAlunoGrupoDireto({{ $amigo->id }}, {{ $grupo->id }})" style="margin-bottom: 10px; margin-right: 5px; cursor: pointer">
                                                                                    <img src="{{ App\User::Avatar($amigo->id) }}" alt="Foto de {{ $amigo->nome }}">
                                                                                    {{ $amigo->nome }}
                                                                                    <input id="input-grupo-amigo-{{ $amigo->id }}" type="hidden" name="id_aluno" value="{{ $amigo->nome }}">
                                                                                </div>
                                                                            @endforeach
                                                                            @else
                                                                            
                                                                            <p>{{ isset($expirado) ? 'Não é possível adicionar usuáios nesse grupo.' : 'Não há amigos que você possa adicionar.' }}</p>
                                                                        @endif
        <!--                                                            add amigos admin-->
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @if($integranteEu->is_admin)
                                                        <div id="remove-alunos-dir" style="display: none;">
                                                            <ul class="collection" style="width:100%;margin-top:0!important;margin-bottom: 0!important;">
                                                                <li class="collection-item" id="amigos-grupo">

                                                                    @if(isset($alunos_int))
                                                                        @foreach($alunos_int as $amigo)
                                                                        <div id="aluno-int-2-{{$amigo->id}}" class="col s6">
                                                                            @if($amigo->id != $thisUser->id)
                                                                                <div id="amigo-dir-{{ $amigo->id }}" class="chip" onclick="removeAlunoGrupo({{ $amigo->id }}, {{ $grupo->id }})" style="margin-bottom: 10px; margin-right: 5px; cursor: pointer">
                                                                                    <img src="{{ App\User::Avatar($amigo->id) }}" alt="Foto de {{ $amigo->nome }}">
                                                                                    {{ $amigo->nome }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        @endforeach
                                                                    @else
                                                                        <p>Não há usuários para serem excluídos.</p>
                                                                    @endif

                                                                </li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                        @endif <!-- É ADMIN--->
                                                                                         
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                                
<!-- PROFESSORES NO GRUPO  -->
                                <li>
                                    <div class="collapsible-header" style="opacity: 0.8"> <i class="mdi-social-person"></i>Professores no grupo</div>
                                    <div class="collapsible-body" style="padding-top:10px">
                                        <div class="row">
                                            <div class="col s12">
                                                <div class="col s12">
                                                    @if(isset($professores_int))
                                                        @foreach($professores_int as $professores)
                                                            <div class="col s2"><img src="{{ App\User::avatar($professores->id) }}" alt="{{$professores->id == $thisUser->id ? 'Este é você' : App\User::verUser($professores->id)->nome }}" data-tooltip="{{ $professores->id == $thisUser->id ? 'Você' :App\User::verUser($professores->id)->nome }}" data-delay="50" data-position="bottom" class="tooltipped circle responsive-img valign profile-image"></div>
                                                        @endforeach
                                                    @else 
                                                    <p class="col s12">Ainda não há professores no grupo. {{ isset($expirado) ? '' : 'Você pode convidar algum, se quiser.' }} </p>
                                                    @endif
                                                </div>
                                                @if(!isset($expirado))
                                                <div id="alunos-add-rec" style="display: none">
                                                    <div class="col s12">
                                                        Adicionados recentemente por você
                                                    <div class="divider" style="margin-bottom: 5px"></div>
                                                    </div>
                                                </div>
                                                <div class="divider"></div>

                                                <div class="input-field col s12">
                                                    <input id="adc-professor-dir" placeholder="Selecione o nome" id="novo-professor-grupo" type="text">

                                                    <label for="adc-professor-grupo" class="active">Convidar Professor</label>
                                                </div>

                                            <div id="adc-professores-dir" style="display: none;">
                                                <ul class="collection" style="width:100%;margin-top:0!important;margin-bottom: 0!important;">
                                                    <li class="collection-item" id="amigos-grupo">
                                                        
                                                        @if(isset($professores_nao_int))
                                                            @foreach($professores_nao_int as $professores)
                                                                <div id="grupo-professor-dir-{{ $professores->id }}" class="chip" onclick="addProfessorGrupoDir({{ $professores->id }}, {{ $grupo->id }})" style="margin-bottom: 10px; margin-right: 5px; cursor: pointer">
                                                                    <img src="{{ App\User::Avatar($professores->id) }}" alt="Foto de {{ $professores->nome }}">
                                                                    {{ $professores->nome }}
                                                                    <input id="input-grupo-professor-{{ $professores->id }}" type="hidden" name="id_professor" value="{{ $professores->nome }}">
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Ainda não há professores que você possa adicionar.</p>
                                                        @endif
                                                        
                                                    </li>
                                                </ul>
                                            </div>   
                                                @endif
                                            </div>

                                        </div>
                                    </li>
                                
                            
                             </ul>
                            
                            
                            <!--/ CONFIGURAÇÕES DO GRUPO  -->