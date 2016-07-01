<div id="modalFirst" class="modal">
    <div class="modal-content">
        <div class="row">
            <h4>Continue seu cadastro</h4> 
            <div class="divider"></div>
            @if(auth()->user()->first_login == 1)
            <p>Você realizou seu cadastro pelo facebook, faltam apenas algumas informações.</p>
            <form action="{{ url('ajax/aluno') }}" method="post" id="aluno">
                <div class="input-field col s6 m6 l6">
                    <select name="escola_id" id="escola_id" onchange="getTurmas()" required>
                        <option value="" disabled selected>Selecione sua ETEC</option>
                        @foreach(\App\Escola::all() as $escola)
                        <option value="{{ $escola->id }}">{{ $escola->nome }}</option>
                        @endforeach
                    </select>
                    <label>Escola</label>
                </div>
                <div class="input-field col s6 m6 l6">
                    <select name="turma_id" id="loadturmas" required>
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
                        <select name="escola_id" id="escola_id" onchange="getTurmasProfDisp(this.value)" required class="validate">
                            <option disabled selected value="">Selecione a escola</option>
                            <option  value="{{ $infoAcad->id }}">{{ $infoAcad->escola }}</option>
                            <!--  AINDA VOU VALIDAR ESTA PARTE! -->
                        </select>
                        <label>Escola</label>
                    </div>
                    <div class="input-field col s12 m6 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso a turma não esteja listada, procure a coordenação de sua escola." id="turmas">
                        <select name="turma_id" id="loadturmas" required onchange="getModulos()">
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
            <p>Coordenador(a), insira as turmas existentes em sua escola</p>
            <form id="setTurmasCoordenador" action="{{ url('ajax/cadastro/setTurmasCoordenador') }}" method="post">
                <div class="col s12">
                    <input type="hidden" name="escola_id" value="{{$infoAcad->id}}">
                    <div class="input-field col s12 m12 l5">
                        <input required name="nome" placeholder="Exemplo: Ensino Médio Integrado Meio Ambiente" id="nome" type="text" class="validate">
                        <label for="nome" class="active" data-error='O nome da turma não parece correto.' style="width: 350px" class="left-align">Turma</label>  
                    </div>
                    <div class="input-field col s12 m12 l5">
                        <input required  name="sigla" placeholder="Exemplo: EMIA" id="sigla" type="text" class="validate">
                        <label for="sigla" class="active" style="width: 350px" class="left-align">Sigla</label>  
                    </div>
                    <div class="input-field col s12 m3 l2 tooltipped" data-tooltip="Número total de semestres" data-position="top" data-delay="300">
                        <select name="modulos" id="modulos" required class="validate">
                            <option disabled selected value="">Selecione</option>
                            <option value="3">3</option>
                            <option value="6">6</option>
                        </select>
                        <label for="modulos">Módulos</label>
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