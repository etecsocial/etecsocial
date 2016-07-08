<div class="container">
   <p class="caption">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
   <div class="divider"></div>
   <div id="borderless-table">
      <h4 class="header">Desafios por matéria</h4>
      <div class="row">
         <div class="col s12 m12 l12">
            <table>
               <thead>
                  <tr>
                     <th>Título</th>
                     <th>Matéria</th>
                     <th>Professor</th>
                     <th>Anexo</th>
                     <th>Pontuação (+)</th>
                     <th>Finaliza em: </th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($desafios as $desafio)
                  <tr>
                     <td><a href="{{ url('/desafios/responder') . '/' . $desafio->id }}">{{$desafio->title}}</a></td>
                     <td>{{ $desafio->subject }}</td>
                     <td>{{ $desafio->responsible->name }}</td>
                     <td>
                       @if($desafio->file != null)
                          <a href="{{ url($desafio->file) }}" class="btn btn-default red">Baixar Anexo</a>
                       @endif
                     </td>
                     <td>+ {{$desafio->reward_points}} pontos</td>
                     <td>{{$desafio->finish}}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
