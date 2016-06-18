<?php
$fields = ['name' => 'Nome Completo',
    'email' => 'Email',
    'password' => 'Senha', 'password_confirmation' => 'Confirme a senha',
    'cod_prof' => 'Código do Professor'];
?>
<div class="professor">
    <form class="form-form" role="form" method="POST" action="{{ url('/register') }}" id="form-register-professor">
        {!! csrf_field() !!}
        <input type="hidden" name="type" value="2"> @foreach ($fields as $field => $name)
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
            <select name="id_escola" id="prof_id_escola" required class="validate">
                <option value="" disabled selected="selected">Selecione sua ETEC</option>
                @foreach($escolas as $escola)
                <option value="{{ $escola->id }}" @if(old('id_escola')==$escola->id ) selected @endif>{{ $escola->nome }}</option>
                @endforeach
            </select>
            <label>Escola</label>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="input-field col s12">
                    <button type="submit" class="waves-effect waves-light btn-large teal darken-1">Cadastrar</button>
                </div>
            </div>
        </div>

    </form>

</div>
