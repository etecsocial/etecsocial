<form class="login-form" role="form" method="POST" action="{{ url('/login') }}">
    {!! csrf_field() !!}
    <div class="row">
        <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            <label>Email</label>
            @if ($errors->has('email'))
            <span class="help-block">
                <strong>Email ou senha inválidos</strong>
            </span>
            @endif
        </div>
        <div class="input-field col s12">
            <i class="material-icons prefix">vpn_key</i>
            <input id="password" name="password" type="password" class="form-control" required value="{{ old('password') }}">
            <label for="password">Senha</label>
            @if ($errors->has('password'))
            <span class="help-block">
             <strong>Email ou senha inválidos</strong>
             </span> @endif
        </div>
        <div class="col s12">
            <input type="checkbox" id="remember" class="filled-in" name="remember" checked>
            <label for="remember">Manter conectado(a)</label> |
            <a href="{{ url('/password/reset') }}" class="medium-small">Perdi minha senha</a>
        </div>
        <div class="input-field col s12">
            <button class="waves-effect waves-green btn-large btn-flat blue white-text" type="submit"><i class="material-icons left">input</i>Entrar</button>
        </div>
    </div>
</form>
