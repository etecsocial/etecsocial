@extends('base')

@section('title')
Recuperar Senha | ETEC Social
@stop

@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" >
<link href="{{ env('ASSETS_URL') }}/custom/1.5/css/particles.min.css" rel="stylesheet">
@stop

@section('jscript')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="{{ env('ASSETS_URL') }}/custom/1.5/js/particles.min.js"></script>
<script src="{{ env('ASSETS_URL') }}/custom/1.5/js/app.particles.js"></script>
<script>
$('#recuperar').submit(function () {
    var dados = $(this).serialize();

    $("#envio").button('loading');
    $.ajax({
        type: "POST",
        data: dados,
        success: function (data) {
            $("#msg").html('<div class="alert alert-warning">' + data + '</div>');

            window.setTimeout(function () {
                window.location.href = 'https://www.etecsocial.com.br';
            }, 5000);
        },
        error: function (data) {
            var errors = data.responseJSON;
            errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each(errors, function (key, value) {
                errorsHtml += '<li>' + value[0] + '</li>';
            });
            errorsHtml += '</ul></di>';

            $("#envio").button('reset');
            $("#msg").html(errorsHtml);
        }
    });

    return false;
});
</script>
@stop

@section('content')
<div id="particles-js"></div>
<div class="row vertical-offset-100" style="margin-top: -500px">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Insira os dados para continuar</h3>
            </div>
            <div class="panel-body">
                <div id="msg"></div>
                {!! Form::open(['id' => 'recuperar']) !!}
                <input name="token" type="hidden" value="{{ $token }}">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control" placeholder="E-mail" name="email" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Nova senha" name="password" type="password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Confirmar senha" name="password_confirmation" type="password">
                    </div>
                    <div align="right">
                        <button class="btn btn-lg btn-danger" id="envio" type="submit" data-loading-text="Aguarde...">Recuperar</button>
                    </div>
                </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop