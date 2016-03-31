@foreach($conversas as $conversa)
<section class="mensagem" id="mensagem-{{ $conversa->id }}">
    
    <p class="email-subject truncate">{{$conversa->assunto}}</p>
    <hr class="grey-text text-lighten-2">
    <div class="email-content-wrap">
        <div class="row">
            <div class="col s10 m10 l10">
                <ul class="collection">
                    <li class="collection-item avatar">
                        <span class="circle light-blue">{{\auth()->user()->verUser($conversa->id_remetente)->nome[0]}}</span>
                        <span class="email-title">{{\auth()->user()->verUser($conversa->id_remetente)->nome}}</span>
                        <p class="truncate grey-text ultra-small"><b>Para:</b> {{\auth()->user()->verUser($conversa->id_destinatario)->nome}}</p>
                        <p class="grey-text ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($conversa->created_at))->diffForHumans()}}</p>
                    </li>
                </ul>
            </div>
            <div class="col s2 m2 l2 email-actions">
                <a><span onclick="delMensagem({{$conversa->id}})" style="cursor: pointer"><i class="mdi-action-delete tooltipped" data-tooltip='Excluir' data-position='bottom'></i></span></a>
                <a><span><i class="mdi-content-archive tooltipped" data-tooltip='Arquivar' data-position='bottom' style="cursor: pointer"></i></span></a>
            </div>
        </div>
        <div class="email-content">{{$conversa->msg}}</div>
    </div>
    
</section>
@endforeach
@if(empty($conversas[0]))
<div class="container">
    <div class="collection">
        <div class="collection-item">
            Não há mensagens neste tópico!
        </div>
    </div>
</div>
@endif
