<?php
$fields = ['nome' => 'Nome Completo', 'username' => 'Usuario', 
           'email' => 'Email', 'email_instuticional' => 'Email Institucional', 
           'password' => 'Senha', 'password_confirmation' => 'Confirme a senha',
           'formacao' => 'Formação', 'cod_prof' => 'Código do Professor'];
?>
<div class="professor">
   <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
   {!! csrf_field() !!}
   <input type="hidden" name="tipo" value="2">
   @foreach ($fields as $field => $name)
   <div class="input-field col s12 m6 l6">
      <input 

      @if (in_array($field, ['password', 'password_confirmation']))
      type="password" 
      @elseif(in_array($field, ['email', 'email_instuticional']))
      type="email"
      @else
      type="text"
      @endif

      class="form-control" name="{{ $field }}" value="{{ old($field) }}">
      <label>{{ $name }}</label>
      
      @if ($errors->has($field))
         <span class="help-block">
            <strong>{{ $errors->first($field) }}</strong>
         </span>
      @endif
   </div>
   @endforeach
      <div class="input-field col s12">
         <button type="submit" class="waves-effect waves-light btn-large red darken-1">Cadastrar</button>
      </div>
   </form>
</div>