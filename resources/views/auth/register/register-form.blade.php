
@for($type = 1; $type < 4; $type++)

<div id="{{ $type }}" class="col s12">
    {!! Form::open(array('url' => '/register')) !!}        
    {!! Form::hidden('type', $type) !!}
    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Seus amigos encontrarão você por este nome!" data-position="top" data-delay="1000">
        <input value="{{ old('name') }}" id="name" type="text"  pattern="^[A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+( [A-ZÉÚÍÓÁÈÙÌÒÀÕÃÑÊÛÎÔÂËYÜÏÖÄ][a-zéúíóáèùìòàõãñêûîôâëyüïöä]+)+$" required name="name" placeholder="Ex. Antônio Carlos" class="validate @if($errors->has('name')) invalid  @elseif($errors->any()) valid @endif">
        <label for="name" data-error="{{ $errors->has('name') ? $errors->first('name') : 'Parece que há algo de errado com seu nome.' }}" data-success="Prazer em conhecê-lo(a)!" style="width: 350px" class="left-align">Como você se chama?</label>
    </div>

    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Informe seu email pessoal" data-position="top" data-delay="1000">
        <input value="{{ old('email') }}" type="email" required name="email" placeholder="Ex. antonio98@exemplo.com" class="validate @if($errors->has('email')) invalid  @elseif($errors->any()) valid @endif">
        <label for="Email" data-error="{{ $errors->has('email') ? $errors->first('email') : 'Esse e-mail não parece correto.' }}" data-success="Ok, depois precisaremos de seu e-mail institucional." style="width: 350px" class="left-align">Qual é seu e-mail?</label>
    </div>

    <div class="input-field col s12 m6 l6 tooltipped" data-tooltip="Uma senha segura contém números, letras e símbolos!" data-position="top" data-delay="1000">
        <input id="password" value="{{ old('password') }}" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" type="password" required name="password" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @endif">
        <label for="password" data-error="{{ $errors->has('password') ? $errors->first('password') : 'Esta senha não parece ser segura.' }}" data-success="Esperamos que se lembre disso mais tarde." style="width: 350px" class="left-align">Digite uma senha segura</label>
    </div>

    <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="Isso ajuda a evitar erros!" data-position="top" data-delay="1000">
        <label for="password_confirmation">Digite a senha novamente</label>
        <input id="password_confirmation" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" value="{{ old('password_confirmation') }}" type="password" required name="password_confirmation" class="validate @if($errors->has('password')) invalid  @elseif($errors->any()) valid @endif">
    </div>

    <div class="input-field col s12 m6 l6 {{ $type == 1 ? 'tooltipped' : null }}" @if($type == 1) data-position='top' data-delay='2000' data-tooltip='Caso sua escola não esteja listada, talvez nenhum coordenador tenha se cadastrado ainda.' @endif >
         <select id="id_escola" name="id_escola" id="id_escola" onchange="getTurmas()" required class="validate @if($errors->has('id_escola')) invalid  @elseif($errors->any()) valid @endif">
            <option disabled @if(!old('id_escola')) selected @endif>Selecione sua ETEC</option>
            @if($type == 3)
                @forelse($escolas as $escola)
                    <option value="{{ $escola['id'] }}" {{ old('id_escola') == $escola['id'] ? 'selected' : null }}> {{ $escola['nome'] }}</option>
                @empty
                    <option>Não há escolas cadastradas</option>
                @endforelse
            @else
                @forelse($escolasCad as $escola)
                    <option value="{{ $escola['id'] }}" {{ old('id_escola') == $escola['id'] ? 'selected' : null }}> {{ $escola['nome'] }}</option>
                @empty
                    <option>Não há escolas cadastradas</option>
                @endforelse
            @endif
        </select>
        <label for="id_escola" data-error="Selecione a escola.">Escola</label>
    </div>
    @if($type != 1)
    <div class="input-field col s12 m6 l6 validate tooltipped" data-tooltip="{{ $type == 2 ? 'Solicite o código na coordenação de sua escola' : 'Obtenha o código entrando em contato conosco através do e-mail contato@etecsocial.com.br' }} " data-position="top" data-delay="1000">
        <label for="cod_{{ ($type == 2) ? 'prof' : 'coord' }}">Código do {{ ($type == 2) ? 'professor' : 'coordenador' }}</label>
        <input id="cod_{{ ($type == 2) ? 'prof' : 'coord' }}" type="number"  required name="cod_{{ ($type == 2) ? 'prof' : 'coord' }}" class="validate 
               {{ ((($type == 2 and $errors->first('cod_prof')) or ( $type == 3 and $errors->first('cod_coord') ))) ? 'invalid' : ($errors->any()) ? 'valid' : null }}">
    </div>
    @else
    <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="Caso sua turma não esteja listada, procure a coordenação de sua escola." id="turmas">
        <select name="id_turma" id="loadturmas" required onchange="getModulos()" class="validate @if($errors->has('id_turma')) invalid  @elseif($errors->any()) valid @endif">
        </select>
        <label for="loadturmas" data-error="{{ $errors->has('id_turma') ? $errors->first('id_turma') : 'Selecione sua turma.'}}">Turma</label>
    </div>
    <div class="input-field col s6 m3 l3 tooltipped" data-position="top" data-delay="2000" data-tooltip="O módulo equivale a um semestre." id="turmas">
        <select name="modulo" id="loadmodulos" required class="validate @if($errors->has('modulo')) invalid  @elseif($errors->any()) valid @endif">
        </select>
        <label for="loadmodulos" data-error="{{ $errors->has('modulo') ? $errors->first('modulo') : 'Selecione o módulo.'}}">Módulo</label>
    </div>
    @endif
    <div class="modal-footer">
        <button class="btn waves-effect waves-light" type="submit" onclick="" id="btn-submit-singup-form">Vamos lá!
            <i class="material-icons right">send</i>
        </button>  
    </div>

    {!! Form::close() !!}
</div>
@endfor