@foreach($conversas as $conversa)
<section id="mensagem-{{ $conversa->id }}">
    <p class="email-subject truncate">{{$conversa->assunto}}</p>
    <hr class="grey-text text-lighten-2">
    <div class="email-content-wrap">
        <div class="row">
            <div class="col s10 m10 l10">
                <ul class="collection">
                    <li class="collection-item avatar">
                        <span class="circle light-blue">{{\App\User::verUser($conversa->id_remetente)->nome[0]}}</span>
                        <span class="email-title">{{\App\User::verUser($conversa->id_remetente)->nome}}</span>
                        <p class="truncate grey-text ultra-small"><b>Para:</b> {{\App\User::verUser($conversa->id_destinatario)->nome}}</p>
                        <p class="grey-text ultra-small">{{$conversa->created_at}}</p>
                    </li>
                </ul>
            </div>
            <div class="col s2 m2 l2 email-actions">
                <a><span onclick="delMensagem({{$conversa->id}})" style="cursor: pointer"><i class="mdi-action-delete"></i></span></a>
                <a><span><i class="mdi-navigation-more-vert" style="cursor: pointer"></i></span></a>
            </div>
        </div>
        <div class="email-content">{{$conversa->msg}}</div>
    </div>
</section>
@endforeach
@if(isset($conversas[0]))
<div class="email-reply">
    <div class="row">
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-reply"></i></a>
            <p class="ultra-small">Responder</p>
        </div>
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-reply-all"></i></a>
            <p class="ultra-small">Responder todas</p>
        </div>
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-forward"></i></a>
            <p class="ultra-small">Próxima</p>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="collection">
        <div class="collection-item">
            Não há mensagens neste tópico!
        </div>
    </div>
</div>
@endif
