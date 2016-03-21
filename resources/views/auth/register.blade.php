@extends('app')
@section('title')
Login | ETEC Social
@stop

@section('style')
{!! Minify::stylesheet(['/css/font.css',
                        '/css/materialize.min.css',
                        '/css/style-new.css'])->withFullURL() !!}
@stop

@section('jscript')
{!! Minify::javascript(['/js/jquery.min.js',
                        '/js/materialize.min.js',
                        '/js/jquery.validate.min.js',
                        '/js/plugins/tokenize/jquery.tokenize.js'])->withFullURL() !!}
@stop

@section('content')
@include('home.nav')
<div class="container">
<div id="login-page" class="row">
    <div class="col s6 card-panel">
        <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}

        <div class="row">
          <div class="input-field col s12 center">
            <img src="{{ url('/images/logo.png') }}" alt="" width=250>
          </div>
        </div>
            <div class="input-field col s12">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                 <label >Nome Completo</label>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
            </div>

             <div class="input-field col s12">
                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                <label >Usuário</label>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-field col s12">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <label >Email</label>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-field col s12">
                <input type="password" class="form-control" name="password">
                <label >Senha</label>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-field col s12">
                <input type="password" class="form-control" name="password_confirmation">
                <label >Confirmar a senha</label>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <div class="input-field col s12">
                <div class="">
                    <button type="submit" class="btn btn-primary">
                        Cadastrar
                    </button>
                </div>
            </div>

      </form>
    </div>
  </div>
</div>
@include('home.footer')
@endsection