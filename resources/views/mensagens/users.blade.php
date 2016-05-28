<ul class="collection">
    @if(isset($users1[0]))
    @foreach($users1 as $user)
    @if(!isset($archives))
    <li class="collection-item avatar user" onclick="getConversa({{ $user->id }}, '{{ explode(' ', $user->name)[0] }}')" id="li-{{$user->id}}">
        @else
    <li class="collection-item avatar user" onclick="getConversaArchives({{ $user->id }}, '{{ explode(' ', $user->name)[0] }}')" id="li-{{$user->id}}">
        @endif
        <span class="circle red lighten-1">{{$user->name[0]}}</span>
<!--                      <img src="" alt="" class="circle">-->
        <span class="email-title">{{ $user->name }}</span>
        @if($last = isset($archives) ? \App\Mensagens::lastMsgArchives($user->id) : \App\Mensagens::lastMsg($user->id))
        <p class="truncate grey-text ultra-small" id="last-msg-{{$user->id}}">
            @if( ($last->id_remetente) == $thisUser->id)
            <b> Você: </b> 
            @else
            <b> {{ explode(' ', $user->name)[0] }}: </b> 
            @endif
            {{ $last->msg }}
        </p>
        @else
        <p id="last-msg-{{$user->id}}" class="truncate grey-text ultra-small" onclick="javascript: novaMensagem({{$user->id}}, '{{\auth()->user()->verUser($user->id)->name}}')">
            Clique para enviar uma mensagem
        </p>
        @endif
        <a href="#!" class="secondary-content email-time">
            <span class="blue-text ultra-small" id="qtd-msgs-{{ $user->id }}">{{ isset($archives) ? \App\Mensagens::countMsgsTopicArchives($user->id) : \App\Mensagens::countMsgsTopic($user->id) }}</span>
        </a>                            
    </li>
    @endforeach
    @endif



    @if(isset($users2[0]))
    @foreach($users2 as $user)
    @if(!isset($archives))
    <li class="collection-item avatar" onclick="getConversa({{ $user->id }}, '{{ explode(' ', $user->name)[0] }}')" id="li-{{$user->id}}">
        @else
    <li class="collection-item avatar" onclick="getConversaArchives({{ $user->id }}, '{{ explode(' ', $user->name)[0] }}')" id="li-{{$user->id}}">
        @endif
        <span class="circle red lighten-1">{{$user->name[0]}}</span>
<!--                      <img src="" alt="" class="circle">-->
        <span class="email-title">{{ $user->name }}</span>
        @if($last = isset($archives) ? \App\Mensagens::lastMsgArchives($user->id) : \App\Mensagens::lastMsg($user->id))
        <p class="truncate grey-text ultra-small" id="last-msg-{{$user->id}}">
            @if( ($last->id_remetente) == $thisUser->id)
            <b> Você: </b> 
            @else
            <b> {{ explode(' ', $user->name)[0] }}: </b> 
            @endif
            {{ $last->msg }}
        </p>
        @else
        <p id="last-msg-{{$user->id}}" class="truncate grey-text ultra-small" onclick="javascript: novaMensagem({{$user->id}}, '{{\auth()->user()->verUser($user->id)->name}}')">
            Clique para enviar uma mensagem
        </p>
        @endif
        <a href="#!" class="secondary-content email-time">
            <span class="blue-text ultra-small" id="qtd-msgs-{{ $user->id }}">{{ isset($archives) ? \App\Mensagens::countMsgsTopicArchives($user->id) : \App\Mensagens::countMsgsTopic($user->id) }}</span>
        </a>                            
    </li>
    @endforeach
    @endif

    @if(empty($users1[0]) and empty($users2[0]))
    <li class="collection-item">
        Não há conversas neste tópico.
    </li>
    @endif
</ul>

