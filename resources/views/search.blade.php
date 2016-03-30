@if(isset($resultados[0]))
@foreach($resultados as $resultado)
<a href="{{ url($resultado->username) }}" style="color: #000">
   <li class="collection-item avatar">
      <img src="{{ auth()->user()->avatar($resultado->id) }}" alt="" class="circle">
      <span class="title"><strong>{{ $resultado->nome }}</strong></span>
      <p>
         {{ auth()->user()->infoAcademica($resultado->id)->modulo }} - {{ auth()->user()->infoAcademica($resultado->id)->curso }} <br>
         {{ auth()->user()->infoAcademica($resultado->id)->instituicao }}
      </p>
   </li>
</a>
@endforeach
@else
<li class="collection-item avatar">
   <p style="margin-top:20px">Nenhum resultado encontrado.</p>
</li>
@endif
