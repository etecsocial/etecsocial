@for($type = 1; $type < 4; $type++)

<div id="{{ $type }}" class="col s12" style="margin-top: 30px">
    {!! Form::open(array('url' => '/register')) !!}
    {!! Form::hidden('type', $type) !!}
    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Seus amigos encontrarão você por este nome!" data-position="top" data-delay="1000">
        <input value="{{ old('name') }}" id="name" type="text"  required name="name" placeholder="Ex. Antônio Carlos" class="validate @if($errors->has('name')) invalid  @elseif($errors->any()) valid @endif">
        <label for="name" data-error="{{ $errors->has('name') ? $errors->first('name') : 'Parece que há algo de errado com seu nome.' }}" data-success="Prazer em conhecê-lo(a)!" style="width: 350px" class="left-align">Como você se chama?</label>
    </div>

    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Informe seu email pessoal" data-position="top" data-delay="1000">
        <input value="{{ old('email') }}" type="email" required name="email" placeholder="Ex. antonio98@exemplo.com" class="validate @if($errors->has('email')) invalid  @elseif($errors->any()) valid @endif">
        <label for="Email" data-error="{{ $errors->has('email') ? $errors->first('email') : 'Esse e-mail não parece correto.' }}" data-success="Ok, depois precisaremos de seu e-mail institucional." style="width: 350px" class="left-align">Qual é seu e-mail?</label>
    </div>

    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Uma senha segura contém números, letras e símbolos!" data-position="top" data-delay="1000">
        <input id="password" value="{{ old('password') }}" type="password" required name="password" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @endif">
        <label for="password" data-error="{{ $errors->has('password') ? $errors->first('password') : 'Esta senha não parece ser segura.' }}" data-success="Esperamos que se lembre disso mais tarde." style="width: 350px" class="left-align">Digite uma senha segura</label>
    </div>

    <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Isso ajuda a evitar erros!" data-position="top" data-delay="1000">
        <label for="password_confirmation">Digite a senha novamente</label>
        <input id="password_confirmation" value="{{ old('password_confirmation') }}" type="password" required name="password_confirmation" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @endif">
    </div>

    <div class="input-field col s12 m6 l6 {{ $type == 1 ? 'tooltipped' : null }}" @if($type == 1) data-position='top' data-delay='2000' data-tooltip='Caso sua escola não esteja listada, talvez nenhum coordenador tenha se cadastrado ainda.' @endif >
         <select id="escola_id" name="escola_id" id="escola_id" onchange="getTurmas()" required class="validate @if($errors->has('escola_id')) invalid  @elseif($errors->any()) valid @endif">
            <option disabled @if(!old('escola_id')) selected @endif>Selecione sua ETEC</option>
            @if($type == 3)
            @forelse($escolas as $escola)
            <option value="{{ $escola['id'] }}" {{ old('escola_id') == $escola['id'] ? 'selected' : null }}> {{ $escola['nome'] }}</option>
            @empty
            <option>Não há escolas cadastradas</option>
            @endforelse
            @else
            @forelse($escolasCad as $escola)
            <option value="{{ $escola['id'] }}" {{ old('escola_id') == $escola['id'] ? 'selected' : null }}> {{ $escola['nome'] }}</option>
            @empty
            <option>Não há escolas cadastradas</option>
            @endforelse
            @endif
        </select>
        <label for="escola_id" data-error="Selecione a escola.">Escola</label>
    </div>
    @if($type == 2)
    <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Solicite o código na coordenação de sua escola" data-position="top" data-delay="1000">
        <input placeholder="O código deve corresponder à escola selecionada" id="cod_prof" type="number"  required name="cod_prof" class="validate @if($errors->has('cod_prof')) invalid  @elseif($errors->any()) valid @endif" value="{{ old('cod_prof')}}">
        <label for="cod_prof" data-error="{{ $errors->first('cod_prof') ? $errors->first('cod_prof') : 'Código inválido.'}}" style="width: 350px" class="left-align">Código do professor</label>
    </div>
    @elseif($type == 3)
    <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Obtenha o código entrando em contato conosco através do e-mail contato@etecsocial.com.br" data-position="top" data-delay="1000">
        <input placeholder="O código deve corresponder à escola selecionada" id="cod_coord" type="number"  required name="cod_coord" class="validate @if($errors->has('cod_coord')) invalid  @elseif($errors->any()) valid @endif" value="{{ old('cod_coord')}}">
        <label for="cod_coord" data-error="{{ $errors->first('cod_coord') ? $errors->first('cod_coord') : 'Código inválido.'}}" style="width: 350px" class="left-align">Código do coordenador</label>
    </div>
    @else
    <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua turma não esteja listada, procure a coordenação de sua escola." id="turmas">
        <select name="turma_id" id="loadturmas" required onchange="getModulos()" class="validate @if($errors->has('turma_id')) invalid  @elseif($errors->any()) valid @endif">
        </select>
        <label for="turma_id" data-error="{{ $errors->first('turma_id') ? $errors->first('turma_id') : 'Selecione sua turma.'}}">Turma</label>
    </div>
    <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="O módulo equivale a um semestre." id="turmas">
        <select name="modulo" id="loadmodulos" required class="validate @if($errors->has('modulo')) invalid  @elseif($errors->any()) valid @endif">
        </select>
        <label for="modulo" data-error="{{ $errors->first('modulo') ? $errors->first('modulo') : 'Selecione o módulo.'}}">Módulo</label>
    </div>
    @endif
    <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" id="btn-submit-singup-form">Criar Conta
            <i class="material-icons right">send</i>
        </button>
    </div>

    {!! Form::close() !!}
</div>
@endfor
