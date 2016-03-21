@extends('app')
@section('title')
Login | ETEC Social
@stop

@section('content')

@include('home.nav')
<style>
#login-page {
      display: table;
      margin: auto;
      vertical-align: middle;
}
</style>

<div class="container">
   <div id="login-page" class="row">
      <div class="col s12 card-panel center">
         <form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}
            <div class="row">
               <div class="input-field col s12 center">
                  <img src="{{ url('/images/logo.png') }}" alt="ETEC Social" width=250>
               </div>
            </div>
            <div class="row margin">
               <div class="input-field col s12">
                  <div class="input-field col s12">
                     <i class="material-icons prefix">account_circle</i>
                     <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}" required>
                     <label for="email">Email</label>
                     @if ($errors->has('email'))
                     <span class="help-block">
                     <strong>{{ $errors->first('email') }}</strong>
                     </span>
                     @endif
                  </div>
               </div>
                  <div class="input-field col s12">
                     <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password" name="password" type="password" class="validate" required  alue="{{ old('password') }}">
                        <label for="password">Senha</label>
                        @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
            </div>
               <div class="row">
                  <div class="input-field col s12">
                     <input type="checkbox" id="remember" class="filled-in" name="remember" checked>
                     <label for="remember">Manter conectado(a)</label>
                  </div>
               </div>
               <div class="row">
                  <div class="input-field col s12">
                     <button class="btn waves-effect waves-light" type="submit">Logar</button>
                     <a class="waves-effect waves-green btn-flat blue white-text">Facebook</a>
                  </div>
               </div>
               <div class="row">
                  <div class="input-field col s12 m6 l6">
                     <a href="{{ url('/register') }}" class="btn margin medium-small red">Cadastrar agora!</a>
                  </div>
                  <div class="input-field col s12 m6 l6">
                     <a href="{{ url('/password/reset') }}" class="btn red lighten-1 margin right-align medium-small">Perdi minha senha</a>
                </div>  
               </div>
         </form>
         </div>
      </div>
   </div>
</div>
@include('home.footer')
@endsection