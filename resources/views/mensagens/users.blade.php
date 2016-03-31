<ul class="collection">
    @if(isset($users[0]))
    @foreach($users as $user)
    <li class="collection-item avatar" onclick="getConversa({{ $user->id }}, '{{ explode(' ', $user->nome)[0] }}')" id="li-{{$user->id}}">
        <span class="circle red lighten-1">{{$user->nome[0]}}</span>
<!--                      <img src="" alt="" class="circle">-->
        <span class="email-title">{{ $user->nome }}</span>
        @if($last = \App\Mensagens::lastMsg($user->id))
        <p class="truncate grey-text ultra-small" id="last-msg-{{$user->id}}">
            @if( ($last->id_remetente) == $thisUser->id)
            <b> Você: </b> 
            @else
            <b> {{ explode(' ', $user->nome)[0] }}: </b> 
            @endif
            {{ $last->msg }}
        </p>
        @else
        <p id="last-msg-{{$user->id}}" class="truncate grey-text ultra-small" onclick="javascript: novaMensagem({{$user->id}}, '{{\auth()->user()->verUser($user->id)->nome}}')">
            Clique para enviar uma mensagem
        </p>
        @endif
        <a href="#!" class="secondary-content email-time">
            <span class="blue-text ultra-small" id="qtd-msgs-{{ $user->id }}">{{ \App\Mensagens::countMsgsTopic($user->id) }}</span>
        </a>                            
    </li>
    @endforeach
    @else
    <li class="collection-item">
    Não há conversas neste tópico.
    </li>
    @endif
</ul>

