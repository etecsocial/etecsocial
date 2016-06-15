@foreach($usuarios as $usuario)
<a href="{{ url($usuario->username) }}" style="color: #000">
    <li class="collection-item avatar" style="margin-left:-15px">
        <img src="{{ auth()->user()->avatar($usuario->id) }}" alt="" class="circle">
        <span class="title"><strong>{{ $usuario->nome_usuario }}</strong></span>
        <p>
            {{ $usuario->sigla }} <br>
            {{ $usuario->nome_etec }}
        </p>
    </li>
</a>
<div class="divider" style="clear:both"></div>
@endforeach
@foreach($grupos as $grupo)
<a href="{{ url('grupo/' . $grupo->url) }}" style="color: #000; padding: 0">
    <li class="collection-item avatar">
        <img src="{{ url('/images/icons/icon-group.png')}}" alt="" class="circle">
        <span class="title">Grupo: <strong>{{ $grupo->nome }}</strong></span>
        <p>
            {{ $grupo->assunto}}
        </p>
        <p>
            @if($grupo->num_participantes > 1)
            Você e outras {{ $grupo->num_participantes }} pessoas estão por aqui.
            @else
            Você está aqui com mais 1 pessoa.
            @endif
        </p>
    </li>
</a>
<div class="divider" style="clear:both"></div>
@endforeach
</div>
<div class="divider" style="clear:both"></div>
<a href="{{ url('busca/' . $termo) }}" style="color: #000; padding: 0">
    <li class="collection-item avatar">
        <i class="circle mdi-action-search"></i>
        <span class="title"><strong>Mais resultados para</strong> "{{ $termo }}"</span>
    </li>
</a>