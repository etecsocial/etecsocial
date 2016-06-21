<!-- MODAL ADD EVENTO -->
<div id="novoevento" class="modal">
    <form method="POST" id="addevento" action="{{ url('ajax/agenda') }}">
        <div class="modal-content">
            <h4>Adicionar Evento</h4>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="title" type="text" required>
                    <label for="title">Título</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="description" type="text">
                    <label for="title">Descrição (opcional)</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input name="start" type="date" class="datepicker" placeholder="Data">
                    <label for="inicio" class="active" id="inicio">Data</label>
                </div>
                <div id="fim" class="input-field col s6" style="display:none">
                    <input name="end" type="date" class="datepicker" placeholder="Data">
                    <label for="fim" class="active">Fim</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="tipo" value="0" id="test11" type="radio" checked>
                    <label for="test11">Um dia</label>
                    <input name="tipo" value="1" id="test21" type="radio">
                    <label for="test21">Mais de um dia</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="publico" value="0" id="test12" type="radio" checked>
                    <label for="test12">Pessoal</label>
                    <input name="publico" value="1" id="test22" type="radio">
                    <label for="test22">Compartilhado</label>
                </div>
            </div>
            <div class="row">
                @if(auth()->user()->type == 2)
                <div class="addturma input-field col s6" style="display:none">
                    <select name="turma" id="turma" type="text">
                        @foreach(auth()->user()->turmas() as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="addturma input-field col s12" style="display:none">
                    <p>Você irá compartilhar esse evento com a sua sala.</p>
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer color-sec">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Add</button>
        </div>
    </form>
</div>
<!-- MODAL ADD EVENTO -->
<!-- MODAL VER POST -->
<div id="verpost" class="modal modal-fixed-footer">
    <div class="modal-content" id="modalpost"></div>
    <div class="modal-footer color-sec">
        <a style="cursor:pointer" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Fechar</a>
    </div>
</div>

{{-- @include('modals.conta') INCUIR DEPOIS --}}

@if(auth()->user()->first_login)
<div id="modalFirst" class="modal">
    <div class="modal-content">
        <div class="row">
            <h4>Continue seu cadastro</h4> 
            <div class="divider"></div>
            @if(auth()->user()->first_login == 1)
            <p>Você realizou seu cadastro pelo facebook, faltam apenas algumas informações.</p>
            <form action="{{ url('ajax/aluno') }}" method="post" id="aluno">
                <div class="input-field col s6 m6 l6">
                    <select name="id_escola" id="id_escola" onchange="getTurmas()" required>
                        <option value="" disabled selected>Selecione sua ETEC</option>
                        @foreach(\App\Escola::all() as $escola)
                        <option value="{{ $escola->id }}">{{ $escola->nome }}</option>
                        @endforeach
                    </select>
                    <label>Escola</label>
                </div>
                <div class="input-field col s6 m6 l6">
                    <select name="id_turma" id="loadturmas" required>
                        <option value="" disabled selected>Selecione sua ETEC primeiro</option>
                    </select>
                    <label>Turma</label>
                </div>
            </form>
            @endif 

            @if(auth()->user()->first_login == 2)
            <p>Professor, ficamos felizes em tê-lo conosco. Agora precisamos saber para quais turmas você leciona.</p>
            <form id="addTurmasProfessor" action="{{ url('ajax/cadastro/setTurmasProfessor') }}" method="get">
                <div class="col s12 m12 l12">
                    <div class="input-field col s12 m6 l6 tooltipped" data-position="top" data-delay="1500" data-tooltip="Você poderá adicionar novas escolas mais tarde.">
                        <select name="id_escola" id="id_escola" onchange="getTurmasProfDisp(this.value)" required class="validate">
                            <option disabled selected value="">Selecione a escola</option>
                            <option  value="{{ $escola->id }}">{{ $escola->etec }}</option>
                            <!--                            @todo esta parte está vunerável!-->
                        </select>
                        <label>Escola</label>
                    </div>
                    <div class="input-field col s12 m6 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso a turma não esteja listada, procure a coordenação de sua escola." id="turmas">
                        <select name="id_turma" id="loadturmas" required onchange="getModulos()">
                        </select>
                        <label>Turma</label>
                    </div>
                    <div class="input-field col s12 m6 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="O módulo equivale a um semestre." id="turmas">
                        <select name="modulo" id="loadmodulos" required>
                        </select>
                        <label>Módulo</label>
                    </div>
                    <div class="input-field col s12 m12 l12 tooltipped" data-tooltip="Será possível alterar isso mais tarde." data-position="top" data-delay="300" >
                        <button type="submit" class="btn btn-primary left"><i class="material-icons left">add</i>Adicionar</button>
                        <button class="btn btn-primary right modal-close done-turmas-prof"><i class="material-icons left">done</i>Concluir</button>
                    </div>   
                </div>
            </form>            
            @endif

            @if(auth()->user()->first_login == 3)
            <p>Coordenador, insira as turmas existentes em sua escola</p>
            <form id="addTurmasCoordenador" action="{{ url('ajax/cadastro/setTurmasCoordenador') }}" method="post">
                <div class="col s12">
                    <input type="hidden" name="id_escola" value="{{$infoAcad->id}}">
                    <div class="input-field col s12 m12 l5">
                        <input name="nome" placeholder="Exemplo: Ensino Médio Integrado Meio Ambiente" id="nome" type="text" class="validate">
                        <label for="nome" class="active">Turma</label>  
                    </div>
                    <div class="input-field col s12 m12 l5">
                        <input name="sigla" placeholder="Exemplo: EMIA" id="sigla" type="text" class="validate">
                        <label for="sigla" class="active">Sigla</label>  
                    </div>
                    <div class="input-field col s12 m3 l2 tooltipped" data-tooltip="Número total de semestres" data-position="top" data-delay="300">
                        <select name="modulos" id="modulo" required class="validate">
                            <option disabled selected value="">Selecione</option>
                            <option value="3">3</option>
                            <option value="6">6</option>
                        </select>
                        <label>Módulos</label>
                    </div>
                    <div class="input-field col s12 m12 l12 tooltipped" data-tooltip="Será possível alterar isso mais tarde." data-position="top" data-delay="300" >
                        <button type="submit" class="btn btn-primary left"><i class="material-icons left">add</i>Adicionar</button>
                        <button class="btn btn-primary right modal-close done-turmas-coord"><i class="material-icons left">done</i>Concluir</button>
                    </div>            
                </div>            
            </form>            
            @endif

        </div>
    </div>
</div>
@endif