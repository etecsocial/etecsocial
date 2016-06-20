<?php
$fields = ['name' => 'Nome Completo', 'email' => 'Email',
           'password' => 'Senha', 'password_confirmation' => 'Confirme a senha'];
?>
<div class="aluno">
    <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="1"> @foreach ($fields as $field => $name)
        <div class="input-field col s12 m6 l6">
            <input @if (in_array($field, [ 'password', 'password_confirmation'])) type="password" @elseif(in_array($field, [ 'email', 'email_instuticional'])) type="email" @else type="text" @endif class="form-control" name="{{ $field }}" value="{{ old($field) }}">
            <label>{{ $name }}</label>
            @if ($errors->has($field))
            <span class="help-block">
        <strong>{{ $errors->first($field) }}</strong>
     </span> @endif
        </div>
        @endforeach
        <div class="input-field col s12 m6 l6 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua escola não esteja listada, talvez nenhum coordenador tenha se cadastrado ainda.">
            <select name="id_escola" id="id_escola" onchange="getTurmas()" required>
                <option disabled selected="selected">Selecione sua ETEC</option>
                @foreach($escolas as $escola)
                <option value="{{ $escola->id }}" @if(old('id_escola')==$escola->id ) selected @endif>{{ $escola->nome }}</option>
                @endforeach
            </select>
            <label>Escola</label>
        </div>
        <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua turma não esteja listada, procure a coordenação de sua escola." id="turmas">
            <select name="id_turma" id="loadturmas" required onchange="getModulos()">
                @if(old('id_turma'))
                <option selected value="{{ old('id_turma->id') }}">{{ old('id_turma->sigla') }}</option>
                @endif
            </select>
            <label>Turma</label>
        </div>
        <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="O módulo equivale a um semestre." id="turmas">
            <select name="modulo" id="loadmodulos" required>
                @if(old('modulo'))
                <option selected value="{{ old('modulo') }}">{{ old('modulo') }}</option>
                @endif
            </select>
            <label>Módulo</label>
        </div>
        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn-large blue darken-1">Cadastrar</button>
        </div>
    </form>
</div>
