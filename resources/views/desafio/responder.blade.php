@extends('desafio.base')

@section('desafio_content')
<div class="container">

    <h5>{{ $desafio->title}}</h5>
    <p class="caption">{{ $desafio->description}}</p>

    <div class="divider"></div>
    @if($desafio_com_resposta == null)
    <div class="row">
      <form class="form-form" method="POST" action="{{ url('/desafios/responder') }}">
          {!! csrf_field() !!}
          <input type="hidden" name="desafio_id" value="{{ $desafio->id }}">

          <div class="input-field col s12 m12 l12">
            <textarea name="resposta" class="materialize-textarea" rows="40"></textarea>
            <label for="resposta">Resposta</label>
          </div>

          <div class="input-field col s12">
              <button type="submit" class="waves-effect waves-light btn-large red darken-1">Responder</button>
          </div>
      </form>
    </div>
    @else
    <h4>Sua resposta:</h4>
    <p class="caption">
        {{$desafio_com_resposta->resposta}}
    <p>
      <div class="divider"></div>
      <h6>Análise do Professor</h6>
      <ul>
        <li>Corrigida?: NÃO</li>
        <li>Comentário: <p></p></li>
      </ul>

    @endif
</div>

@stop
