@foreach($usuarios as $usuario)
<a href="{{ url($usuario->username) }}" style="color: #000">
   <li class="collection-item avatar">
      <img src="{{ auth()->user()->avatar($usuario->id) }}" alt="" class="circle">
      <span class="title"><strong>{{ $usuario->nome_usuario }}</strong></span>
      <p>
         {{ explode(' ', auth()->user()->infoAcademica($usuario->id)->modulo)[0] }} {{ $usuario->sigla }} <br>
         {{ $usuario->nome_etec }}
      </p>
   </li>
</a>
<div class="divider" style="clear:both"></div>
@endforeach
@foreach($grupos as $grupo)
<a href="{{ url('grupo/' . $grupo->url) }}" style="color: #000; padding: 0">
   <li class="collection-item avatar">
      <img src="{{ url('/images/default-user.png')}}" alt="" class="circle">
      <span class="title">Grupo: <strong>{{ $grupo->nome }}</strong></span>
      <p>
         {{ $grupo->assunto}}
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
      <span class="title"><strong>Mais usuarios para</strong> "{{ $termo }}"</span>
   </li>
</a>