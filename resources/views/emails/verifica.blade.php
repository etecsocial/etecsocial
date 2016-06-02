<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verificação de e-mail</h2>
        <div>
            <p>Obrigado por se cadastrar na ETEC Social.<p>
            <p>Por favor, confirme seu e-mail para finalizar seu cadastro:</p>
            <a href="{{ url('/confirm/verify/') . '/' . $confirmation_code }}">Verificar agora</a><br><br>
            <p>Atenciosamente,<br>ETEC Social.</p>
        </div>
    </body>
</html>