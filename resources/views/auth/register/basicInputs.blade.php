<input type="hidden" name="type" value="{{ $type }}"> 

<div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Seus amigos encontrarão você por este nome!" data-position="top" data-delay="1000">
    <input value="{{ old('name') }}" id="name" type="text"  pattern="^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$" required name="name" placeholder="Ex. Antônio Carlos" class="validate @if($errors->has('name')) invalid  @elseif($errors->any()) valid @else  @endif">
    <label for="name" data-error="{{ $errors->has('name') ? $errors->first('name') : 'Parece que há algo de errado com seu nome.' }}" data-success="Prazer em conhecê-lo!" style="width: 350px" class="left-align">Como você se chama?</label>
</div>
<div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Informe seu email pessoal" data-position="top" data-delay="1000">
    <input value="{{ old('email') }}" type="email" required name="email" placeholder="Ex. antonio98@exemplo.com" class="validate @if($errors->has('email')) invalid  @elseif($errors->any()) valid @else  @endif">
    <label for="Email" data-error="{{ $errors->has('email') ? $errors->first('email') : 'Esse e-mail não parece correto.' }}" data-success="Ok, depois precisaremos de seu e-mail institucional." style="width: 350px" class="left-align">Qual é seu e-mail?</label>
</div>
<div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Uma senha segura contém números, letras e símbolos!" data-position="top" data-delay="1000">
    <input id="password" value="{{ old('password') }}" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" type="password" required name="password" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @else  @endif">
    <label for="password" data-error="{{ $errors->has('password') ? $errors->first('password') : 'Esta senha não parece ser segura.' }}" data-success="Esperamos que se lembre disso mais tarde." style="width: 350px" class="left-align">Digite uma senha segura</label>
</div>
<div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Isso ajuda a evitar erros!" data-position="top" data-delay="1000">
    <input id="password_confirmation" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" value="{{ old('password_confirmation') }}" type="password" required name="password_confirmation" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @else  @endif">
    <label for="password_confirmation">Digite a senha novamente</label>
</div>
<div class="input-field col s12 m6 l6 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua escola não esteja listada, talvez nenhum coordenador tenha se cadastrado ainda.">
    <select id="id_escola" name="id_escola" id="id_escola" onchange="getTurmas()" required class="validate @if($errors->has('id_escola')) invalid  @elseif($errors->any()) valid @else  @endif">
        <option disabled @if(!old('id_escola')) selected @endif>Selecione sua ETEC</option>
        @foreach($escolas as $escola)
        <option value="{{ $escola->id }}" {{ old('id_escola') == $escola->id ? 'selected' : '' }}>{{ $escola->nome }}</option>
        @endforeach
    </select>
    <label for="id_escola" data-error="Selecione a escola.">Escola</label>
</div>