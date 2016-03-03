@foreach($resultados_alunos as $resultado)
        <a href="{{ url($resultado->username) }}" style="color: #000">
            <li class="collection-item avatar">
                <img src="{{ App\User::avatar($resultado->id) }}" alt="" class="circle">
                <span class="title"><strong>{{ $resultado->nome_usuario }}</strong></span>
                <p>
                    {{ explode(' ', App\User::infoAcademica($resultado->id)->modulo)[0] }} {{ $resultado->sigla }} <br>
                    {{ $resultado->nome_etec }}
                </p>

            </li>
            
        </a>
<div class="divider"></div>
@endforeach

@foreach($resultados_prof as $resultado)
<a href="{{ url($resultado->username) }}" style="color: #000">
    <li class="collection-item avatar">
        <img src="{{ App\User::avatar($resultado->id) }}" alt="" class="circle">
        <span class="title"><strong>{{ $resultado->nome }}</strong></span>
        <p>Professor</p>
    </li>
</a>
<div class="divider"></div>
@endforeach

@if((!isset($resultados_alunos[0])) and (!isset($resultados_prof[0])))
<li class="collection-item avatar">
    <p style="margin-top:20px">Nenhum resultado encontrado.</p>
</li>
@endif
<a href="{{ url('busca/' . $termo) }}" style="color: #000">
    <li class="collection-item avatar">
        <i class="circle mdi-action-search"></i>
        <span class="title"><strong>Mais resultados para</strong></span>
        <p>"{{ $termo }}"</p>
    </li>
</a>