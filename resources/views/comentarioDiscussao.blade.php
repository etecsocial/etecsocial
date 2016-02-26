@foreach(App\ComentarioDiscussao::where('id_discussao', $id_discussao)->where('id', '>', $id_comentario)->get() as $comentario)
<li id="com-disc-{{ $comentario->id }}" class="collection-item avatar com-disc-{{ $id_discussao }}" style="height: auto; min-height:65px" data-id="{{ $comentario->id }}">

    @if(Auth::user()->id == $comentario->id_user) 
    <a href="#modalExcluirComentario" onclick="excluirComentarioDiscussao({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>

    @endif
    <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
    <div style="max-height: 80px; overflow-y: auto">
        <p>{{ $comentario->comentario }}</p>
    </div>
            <span class="ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($comentario->created_at))->diffForHumans() }}</span>

</li>

@endforeach     