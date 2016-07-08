@extends('desafio.base')
@section('desafio_content')
<div class="container">
   <h5>{{ $desafio->title }}</h5>
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
   @if($desafio_com_resposta->corrigida)
   <div class="m12 s12 col">
      @if($desafio_com_resposta->correto)
      <div class="card-panel green darken-1">
         @else
         <div class="card-panel red darken-1">
            @endif
            <div class="row">
               <div class="col l8 white-text">
                  <h5>Análise do Professor</h5>
                  <h6>
                     @if($desafio_com_resposta->correto)
                     Você acertou o desafio
                     @else
                     Você errou o desafio
                     @endif
                  </h6>
                  <p><strong>Comentário do professor:</strong> {{ $desafio_com_resposta->resposta_comentario}}</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endif
   @endif
</div>
@stop
