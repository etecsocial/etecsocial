@extends('desafio.base')

@section('desafio_content')
<div class="container">
    @if ($respostas == null)
      <p class="caption">Nenhuma resposta foi adicionada ainda, a turma já foi notificada do desafio!</p>
    @else
    <div id="borderless-table">
       <h4 class="header">Respostas</h4>
       <div class="row">
          <div class="col s12 m12 l12">
             <table>
                <thead>
                   <tr>
                      <th>Aluno</th>
                      <th>Resposta</th>
                      <th>Comentário</th>
                      <th>Correto?</th>
                   </tr>
                </thead>
                <tbody>
                   @foreach($respostas as $resposta)
                   <form method="post" action="{{url('/desafios/respostas')}}">
                     <input type="hidden" name="resposta_id" value="{{$resposta->id}}">
                     <tr>
                        <td>{{ $resposta->aluno->name }}</td>
                        <td>{{ $resposta->resposta }}</td>
                        <td><textarea name="resposta_comentario"></textarea></td>
                        <td><button type="submit" value="sim" name="correcao">SIM</button> / <button type="submit" name="correcao" value="nao">NÃO</button></td>
                     </tr>
                  </form>
                   @endforeach
                </tbody>
             </table>
          </div>
       </div>
    </div>
    @endif
</div>
@stop
