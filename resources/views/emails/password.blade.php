<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Recuperação de Senha</h2>
        <div>
            <p>Olá {{ $user->name }}, como vai?</p>
            <p>Você solicitou a recuperação da senha de sua conta da ETEC Social.
            <p>Clique <a href="{{ URL::to('/password/reset/' . $token) }}">aqui</a> para alterar sua senha.
            <br>
            <p>Se não foi você quem solicitou isso, por favor, ignore esse e-mail.<p>
            <p>Atenciosamente,<br>ETEC Social.</p>
        </div>
    </body>
</html>