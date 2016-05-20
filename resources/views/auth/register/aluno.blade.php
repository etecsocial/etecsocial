<?php
$fields = ['name' => 'Nome Completo', 'email' => 'Email', 'rm' => 'RM', 
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
            <div class="input-field col s12 m6 l6">
                <select name="id_escola" id="id_escola" onchange="turmas()" required>
                    <option value="" disabled>Selecione sua ETEC</option>
                    @foreach($escolas as $escola)
                    <option value="{{ $escola->id }}" @if(old( 'id_escola')==$escola->id ) selected @endif>{{ $escola->nome }}</option>
                    @endforeach
                </select>
                <label>Escola</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <select name="id_turma" id="loadturmas" required>
                    <option value="" disabled selected>Selecione sua ETEC primeiro</option>
                </select>
                <label>Turma</label>
            </div>
            <div class="input-field col s12">
                <button type="submit" class="waves-effect waves-light btn-large red darken-1">Cadastrar</button>
            </div>
        </form>
    </div>
