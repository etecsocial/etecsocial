@foreach(App\ComentarioPergunta::where('id_pergunta', $id_pergunta)->where('id', '>', $id_comentario)->get() as $comentario)
<li class="collection-item avatar com-perg-{{ $id_pergunta }}" style="height: auto; min-height:65px" data-id="{{ $comentario->id }}">
   @if(Auth::user()->id == $comentario->id_user) 
   <a href="#modalExcluirComentario" onclick="excluirComentarioPergunta({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
   @endif
   <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
   <div style="max-height: 80px; overflow-y: auto">
      <p>{{ $comentario->comentario }}</p>
   </div>
   <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comentario->created_at))->diffForHumans() }}</span>
</li>
@endforeach