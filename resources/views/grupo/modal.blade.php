<div id="modalExcluirComentarioDiscussao" class="modal">
    <form  id="excluirComentarioDiscussao" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Comentario</h4>
            <div class="divider"></div>
            <p>Tem certeza que deseja excluir este comentario?</p>
        </div>
        <input type="hidden" value="1" name="discussao">
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div><!--modal excluir comentario-->
<div id="modalExcluirPergunta" class="modal">
    <form id="excluirPergunta" method="post">
        <div class="modal-content">
            <h4>Excluir pergunta</h4>
            <div class="divider"></div>
            <p>Tem certeza que deseja excluir esta pergunta?</p>
        </div>
        <input type="hidden" value="" name="id_pergunta" id="id_pergunta_excluir">
        <input type="hidden" value="{{ $grupo->id }}" name="id_grupo" id="id_pergunta_excluir">
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div><!--modal excluir Pergunta-->
<div id="modalExcluirDiscussao" class="modal">
    <form id="excluirDiscussao" method="post">
        <div class="modal-content">
            <h4>Excluir discussão</h4>
            <div class="divider"></div>
            <p>Tem certeza que deseja excluir esta discussão?</p>
        </div>
        <input type="hidden" value="" name="id_discussao" id="id_discussao_excluir">
        <input type="hidden" value="{{ $grupo->id }}" name="id_grupo" id="id_grupo">
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div><!--modal excluir Discussao-->

<div id="modalExcluirComentarioPergunta" class="modal">
    <form  id="excluirComentarioPergunta" method="DELETE">
        <div class="modal-content">
            <h4>Excluir Resposta</h4>
            <div class="divider"></div>
            <p>Tem certeza que deseja excluir esta resposta?</p>
            <div class="divider col s6"></div><p>
            <p class="ultra-small">Mesmo que não seja correta, sua resposta é muito importante!</p>
        </div>
        <div class="modal-footer">
            <a class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat ">Excluir</button>
        </div>
    </form>
</div><!--modal excluir comentario pergunta-->

@if(!$banido)
<form method="post" id="sairGrupo" action="{{ url('ajax/grupo/sair')}}">
    <div id="modalSairGrupo" class="modal modal-fixed-footer">
        <input type="hidden" name="id_grupo" value="{{$grupo->id}}">
        <div class="modal-content">
            <h4 ><strong>Sair do grupo</strong></h4><li class="divider"></li>
            <div class="row">
                <div class="col s12">
                    <p>Tem certeza que deseja sair do grupo {{ $grupo-> nome}}?</p>
                    <p>Se sim, poderia nos dizer o motivo? </p>
                </div>
                <input type="hidden" name="id_grupo" value="{{ $grupo-> id}}">
                <div class="input-field col s12 l6">
                    <input name="motivo" type="radio" id="test1" value="Conteúdo inadequado">
                    <label for="test1">Conteúdo inadequado</label>

                    <input name="motivo" type="radio" id="test2" value="Já encontrou o que procurava" checked>
                    <label for="test2">Já encontrei o que procurava</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="motivo" type="radio" id="test3" value="Não está o ajudando">
                    <label for="test3">Não está me ajudando</label>

                    <input name="motivo" type="radio" id="test4" value="Não gosta dos demais participantes">
                    <label for="test4">Não gosto dos demais participantes</label>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col s12">
                    <div class="divider"></div>
                
                <p class="card-panel red darken-1 white-text"><strong>Atenção: </strong>Você só poderar retornar aqui se alguém o adicionar novamente.</p>
                    </div>
            </div>
        </div>
        <div class="modal-footer color-sec-darken">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </div>
</form><!--modal sair grupo-->

@if(($integranteEu->is_admin) and ($denuncia = \App\DenunciaGrupo::where('id_grupo', $grupo->id)->where('visto', 0)->orderBy('created_at', 'desc')->first())))
@if($pub = \App\GrupoDiscussao::where('id_grupo', $denuncia->id_grupo)->where('id', $denuncia->id_pub)->first())

<div id="modalAnalisarDenunciaGrupo" class="modal modal-fixed-footer" style='height: auto;min-height: 520px'>
    <div class="modal-content" style="overflow-x: hidden; overflow-y: scroll;">
        <form method="post" id="analisaDnunciaGrupo" class="col s12" action="{{ url('ajax/grupo/denuncia/analisa')}}">
            <h4 ><strong>Olá administrador!</strong></h4><li class="divider"></li>
            <div class="row" style="margin-bottom: 15px">
                <div class="col s12">
                    <p>Recebemos uma denúncia referente a uma publicação de um dos usuários do grupo e gostaría-mos que você desse seu parecer.</p>

                    <p>A publicação é a seguinte:</p>
                    <div class="divider col s6 center-align"></div>
                    <p><strong>Assunto:</strong> {{ $pub->assunto }}</p>
                    <p><strong>{{$denuncia->tipo == 'discussao' ? 'Discussão' : 'Pergunta'}}:</strong> {{ $pub->discussao }}</p>
                    <div class="divider col s6 center-align center"></div>
                    <p>Segundo o autor da denúncia, o conteúdo da publicação ou parte dele:</p>
                    <p>{{ $denuncia->denuncia }}</p>
                    <div class="divider"></div>
                </div>

                <p>Você concorda com a afirmação acima? Caso queira, pode optar por excluir a publicação do usuário.</p>
                <div class="input-field col s12">
                    <div class='col s6'>
                        <input name="resposta" type="radio" id="resposta1" value="1">
                        <label for="resposta1">Sim, a publicação deve ser excluida. O grupo será melhor sem ela.</label>
                    </div>
                    <div class='col s6'>
                        <input name="resposta" type="radio" id="resposta2" value="2">
                        <label for="resposta2">Não, a denúncia não é consistente.</label>
                    </div>
                </div>
                <div class="input-field col s12">
                    <p>
                        <input type="checkbox" id="ban" name="banir" value="1">
                        <label for="ban">Banir autor da publicação</label>
                    </p>
                </div>
            </div>

            <input type="hidden" name="id_grupo" value="{{ $grupo->id}}">
            
            <input type="hidden" name="created_at" value="{{ $denuncia->created_at}}">
            <input type="hidden" name="id_pub" value="{{ $denuncia->id_pub }}" id="id_pub">
            <input type="hidden" name="tipo_pub" value="{{ $denuncia->tipo }}" id="tipo_pub">
            <input type="hidden" name="id_autor_pub" value="" id="{{ $denuncia->id_autor_pub }}}">


            <div class="modal-footer color-sec-darken" style='margin-top: 20px'>
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
                <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Concluir</button>
            </div>
        </form>
    </div>
</div><!--modal denuncia-->


@endif
@endif

<div id="modalDenunciaGrupo" class="modal modal-fixed-footer">
    <form method="post" id="denunciaGrupo" class="col s12" action="{{ url('ajax/grupo/denuncia/create')}}">
        <div class="modal-content" style="overflow-x: hidden; min-height: 500px ">
            <h4 ><strong>Denunciar publicação </strong></h4><li class="divider"></li>
            <div class="row">
                <div class="col s12">
                    <p>O que há de errado com esta publicação?</p>
                </div>
                <input type="hidden" name="id_autor_pub" value="" id="id_autor_pub">
                <input type="hidden" name="id_grupo" value="{{ $grupo->id}}">
                <input type="hidden" name="id_pub" value="" id="id_pub">
                <input type="hidden" name="tipo_pub" value="" id="tipo_pub">
                
                <div class="input-field col s6">
                    <input name="motivo" type="radio" id="motivo1" value="É grosseiro, vulgar ou usa termos inadequados">
                    <label for="motivo1">É grosseiro, vulgar ou usa termos inadequados</label>

                    <input name="motivo" type="radio" id="motivo2" value="É sexualmente explícito">
                    <label for="motivo2">É sexualmente explícito</label>
                </div>
                <div class="input-field col s6">
                    <input name="motivo" type="radio" id="motivo3" value="É assédio ou discurso de ódio">
                    <label for="motivo3">É assédio ou discurso de ódio</label>

                    <input name="motivo" type="radio" id="motivo4" value="É ameaçador, violento ou suicida">
                    <label for="motivo4">É ameaçador, violento ou suicida</label>
                </div>
            </div>
            <br>
            <div class="divider"></div>
            <p>Fique tranquilo. A ETEC Social preza pela qualidade do conteúdo de suas publicações.
                Buscaremos resolver isso o mais rápido possível, de forma correta e eficiente. Obrigado pela participação!
            </p>

        </div>
        <div class="modal-footer color-sec-darken" style="margin-left: -11px">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </form>
</div><!--modal denuncia-->





@if($integranteEu->is_admin)
<!-- MODAL EXCLUIR GRUPO -->
<form method="post" id="excluirGrupo" action="{{ url('ajax/grupo/excluir')}}">
    <div id="modalExcluirGrupo" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 ><strong>Excluir grupo</strong></h4><li class="divider"></li>
            <div class="row">
                <div class="col s12">
                    <p>Tem certeza que deseja excluir o grupo {{ $grupo-> nome}}?</p>
                    <p class="card-panel red darken-1 white-text"><strong>ATENÇÃO:</strong> Todo o material publicado nele será perdido!</p>

                </div>
                <input type="hidden" name="idgrupo" value="{{ $grupo-> id}}">
            </div>
        </div>
        <div class="modal-footer color-sec-darken">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Excluir</button>
        </div>
    </div>
</form>
<!-- FIM EXCLUIR ADD GRUPO -->
@endif
@endif

<!-- MODAL ADD GRUPO -->
<div id="modalAddGrupo" class="modal modal-fixed-footer" style="height: 850px!important">
    <form method="post" id="criarGrupo" action="{{ url('ajax/grupo/criar')}}">
        <div class="modal-content" style="height: 850px!important; overflow: auto">
            <h4>Criar Grupo de Estudos</h4>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field col s6">
                        <input name="nome" id="nome-grupo" type="text" class="validate" length="25" required>
                        <label>Nome</label>
                    </div>

                    <div class="input-field col s6">
                        <input name="assunto" id="assunto-grupo" type="text" class="validate" length="30" required>
                        <label>Assunto</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s6">
                        <input name="url" id="url-grupo" type="text" class="validate tooltipped" length="35" placeholder="etecsocial.com/grupo/" required data-position="bottom" data-delay="50" data-tooltip="Como as pessoas irão acessar o grupo.">
                        <label class="active">URL</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="expiracao" id="expiracao-grupo" type="date" data-position="bottom" data-delay="50" data-tooltip="O grupo é para um evento específico ou permanente?.">
                        <label class="active">Expiração</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field col s12">
                        <input name="materia" id="materia-grupo" type="text" class="validate tooltipped" length="45" placeholder="Ex.: Matemática" data-position="bottom" data-delay="50" data-tooltip="Caso não, deixe este campo em branco.">
                        <label class="active">O grupo de estudos é para alguma matéria específica?</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer color-sec">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </form>
</div>
<!-- MODAL ADD GRUPO -->