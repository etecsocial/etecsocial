<style>
   .delete{
   cursor: pointer;
   }
</style>
<div class="container">
   @if (!$desafios->isEmpty())
   <div id="borderless-table">
      <h4 class="header">Seus Desafios publicados</h4>
      <div class="row">
         <div class="col s12 m12 l12">
            <table>
               <thead>
                  <tr>
                     <th>Título</th>
                     <th>Matéria</th>
                     <th>Respostas</th>
                     <th>Pontuação (+)</th>
                     <th>Finaliza em: </th>
                     <th>Ações:</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($desafios as $desafio)
                  <tr id="desafio-{{$desafio->id}}">
                     <td><a href="{{ url('/desafios/edit') . '/' . $desafio->id }}">{{$desafio->title}}</a></td>
                     <td>{{ $desafio->subject }}</td>
                     <td>{{ count($desafio->respostas) }}</td>
                     <td>+ {{$desafio->reward_points}} pontos</td>
                     <td>{{$desafio->finish}}</td>
                     <td>
                        <a href="{{ url('/desafios/respostas/') . '/' . $desafio->id }}" data-tooltip="Ver respostas" data-position="top" data-delay="10" class="tooltipped"><i class="mdi-action-face-unlock color-sec-darken-text"></i></a>
                        <a data-tooltip="Excluir desafio" data-position="top" data-delay="10" class="delete tooltipped" id="{{$desafio->id}}"><i class="mdi-action-delete color-sec-darken-text"></i></a>
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endif
</div>
<div class="divider"></div>
<div class="container">
   <h5>Adicionar novo desafio</h5>
   <p class="caption">Você pode adicionar um desafio abaixo, e toda as turmas selecionadas serão notificadas, e caso um aluno responder você será notificado e poderá corrigir as respostas.</p>
   <div class="row">
      <form class="form-form" role="form" method="POST" action="{{ url('/desafios/store') }}">
         {!! csrf_field() !!}
         <div class="input-field col s12 m12 l12">
            <input type="text" name="title">
            <label>Título</label>
         </div>
         <div class="input-field col s12 m12 l12">
            <textarea name="description" class="materialize-textarea"></textarea>
            <label for="description">Descrição</label>
         </div>
         <div class="input-field col s12 m12 l6">
            <input type="text" name="subject" placeholder="Matemática">
            <label>Matéria</label>
         </div>
         <div class="input-field col l3">
            <input type="number" name="reward_points" placeholder="100">
            <label>Pontos ganhos</label>
         </div>
         <div class="input-field col l3">
            <select name="turmas[]" multiple>
               @foreach($turmas as $turma)
               <option value="{{$turma->id}}">{{$turma->turma->sigla}}</option>
               @endforeach
            </select>
         </div>
         <div class="input-field col l2">
            <input type="date" class="datepicker" name="finish">
            <label>Data limite</label>
         </div>
         <div class="input-field col l4">
            <div class="file-field input-field">
                <input class="file-path validate" type="text">
                <div class="btn red darken-1">
                    <span>Adicionar anexo</span>
                    <input type="file" name="file">
                </div>
            </div>
         </div>
         <div class="input-field col s12 right-align">
            <button type="submit" class="waves-effect waves-light btn-large red darken-1">Cadastrar</button>
         </div>
      </form>
   </div>
</div>
