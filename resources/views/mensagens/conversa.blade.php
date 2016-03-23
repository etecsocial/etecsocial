@foreach($conversas as $conversa)
@if(($conversa->id_remetente == Auth::user()->id) and (!$conversa->copia_rem == 0) or ($conversa->id_destinatario == Auth::user()->id) and (!$conversa->copia_dest == 0))
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
@endif
@endforeach
<div class="email-reply">
    <div class="row">
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-reply"></i></a>
            <p class="ultra-small">Reply</p>
        </div>
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-reply-all"></i></a>
            <p class="ultra-small">Reply all</p>
        </div>
        <div class="col s4 m4 l4 center-align">
            <a href="!#"><i class="mdi-content-forward"></i></a>
            <p class="ultra-small">Forward</p>
        </div>
    </div>
</div>
