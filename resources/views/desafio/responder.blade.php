@extends('desafio.base')

@section('desafio_content')
<div class="container">

    <h5>{{ $desafio->title}}</h5>
    <p class="caption">{{ $desafio->description}}</p>

    <div class="divider"></div>

    <div class="row">
      <form class="form-form" method="POST" action="{{ url('/desafios/responder') }}">
          {!! csrf_field() !!}
          <input type="hidden" name="desafio_id" value="{{ $desafio->id }}">

          <div class="input-field col s12 m12 l12">
            <textarea name="description" class="materialize-textarea" rows="40"></textarea>
            <label for="description">Resposta</label>
          </div>

          <div class="input-field col s12">
              <button type="submit" class="waves-effect waves-light btn-large red darken-1">Responder</button>
          </div>
      </form>
  </div>
</div>

@stop
