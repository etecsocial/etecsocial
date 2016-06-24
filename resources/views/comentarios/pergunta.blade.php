@foreach(App\ComentarioPergunta::where('id_pergunta', $id_pergunta)->where('id', '>', $comentario_id)->get() as $comentario)
<li class="collection-item avatar com-perg-{{ $id_pergunta }}" style="height: auto; min-height:65px" data-id="{{ $comentario->id }}">
    @if(auth()->user()->id == $comentario->user_id)
    <a href="#modalExcluirComentario" onclick="excluirComentarioPergunta({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a> @endif
    <img src="{{ auth()->user()->avatar($comentario->user_id) }}" data-tooltip="Este é {{ auth()->user()->verUser($comentario->user_id)->nome }}" class="circle tooltipped">
    <div style="max-height: 80px; overflow-y: auto">
        <p>{{ $comentario->comentario }}</p>
    </div>
    <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comentario->created_at))->diffForHumans() }}</span>
</li>
@endforeach
