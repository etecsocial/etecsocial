<div class="aluno">
    <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}        
        
        @include('auth.register.basicInputs', ['type' => 1])
        <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua turma não esteja listada, procure a coordenação de sua escola." id="turmas">
            <select name="id_turma" id="loadturmas" required onchange="getModulos()" class="validate @if($errors->has('id_turma')) invalid  @elseif($errors->any()) valid @else  @endif">
            </select>
            <label for="loadturmas" data-error="{{ $errors->has('id_turma') ? $errors->first('id_turma') : 'Selecione sua turma.'}}">Turma</label>
        </div>
        <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="O módulo equivale a um semestre." id="turmas">
            <select name="modulo" id="loadmodulos" required class="validate @if($errors->has('modulo')) invalid  @elseif($errors->any()) valid @else  @endif">
            </select>
            <label for="loadmodulos" data-error="{{ $errors->has('modulo') ? $errors->first('modulo') : 'Selecione o módulo.'}}">Módulo</label>
        </div>
        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn-large blue darken-1">Cadastrar</button>
        </div>
    </form>
</div>
