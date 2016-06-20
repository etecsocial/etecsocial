<div class="aluno">
    <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}        
        
        <input type="hidden" name="type" value="1"> 
        
        <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Seus amigos encontrarão você por este nome!" data-position="top" data-delay="1000">
            <input id="name" type="text"  pattern="^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ]{1}[a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ]{1}[a-zéúíóáèùìòàõãñêûîôâëyüïöä]+){1,3}$" required name="name" placeholder="Ex. Antônio Carlos" class="validate {{ $errors->has('name') ? 'invalid' : $errors->any() ? 'valid' : '' }}">
            <label for="name" data-error="Parece que há algo de errado com seu nome." data-success="Prazer em conhecê-lo!" style="width: 350px" class="left-align">Como você se chama?</label>
        </div>
        <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Seu e-mail institucional será solicitado mais tarde." data-position="top" data-delay="1000">
            <input type="email" required name="email" placeholder="Ex. antonio98@exemplo.com" class="validate {{ $errors->has('email') ? 'invalid' : $errors->any() ? 'valid' : '' }}">
            <label for="Email" data-error="{{ $errors->has('email') ? $errors->first('email') : 'Esse e-mail não parece correto.' }}" data-success="Ok, depois precisaremos de seu e-mail institucional." style="width: 350px" class="left-align">Qual é seu e-mail?</label>
        </div>
        <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Uma senha segura contém números, letras e símbolos!" data-position="top" data-delay="1000">
            <input type="password" required name="password">
            <label for="password" data-error="{{ $errors->password or '' }}">Digite uma senha segura</label>
        </div>
        <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Isso ajuda a evitar erros!" data-position="top" data-delay="1000">
            <input type="password" required name="password_confirmation" style="width: 350px" class="left-align">
            <label for="password_confirmation" data-error="{{ $errors->password_confirmation or '' }}">Digite a senha novamente</label>
        </div>
        <div class="input-field col s12 m6 l6 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua escola não esteja listada, talvez nenhum coordenador tenha se cadastrado ainda.">
            <select name="id_escola" id="id_escola" onchange="getTurmas()" required>
                <option disabled selected="selected">Selecione sua ETEC</option>
                @foreach($escolas as $escola)
                <option value="{{ $escola->id }}" {{ old('id_escola') == $escola->id ? 'selected' : '' }}>{{ $escola->nome }}</option>
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
