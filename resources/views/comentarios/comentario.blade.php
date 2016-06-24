@foreach(App\Comentario::where('id_post', $id_post)->where('id', '>', $id_comentario)->get() as $comentario)
<li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $comentario->id_post }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">
    @if(auth()->user()->id == $comentario->user_id)
    <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
    <i onclick="exibeEditarComentario({{ $comentario->id }}, $('#com-{{ $comentario->id }}- text').text())" class="mdi-editor-mode-edit right tiny" style="color: #039be5; cursor: pointer"></i> @else
    <i class="mdi-hardware-keyboard-arrow-down right small-photo" style="color: #039be5; cursor: pointer"></i>
    <i class="mdi-hardware-keyboard-arrow-up right small-photo" style="color: #039be5; cursor: pointer"></i> @endif
    <img src="{{ auth()->user()->avatar($comentario->user_id) }}" data-tooltip="Este é {{ auth()->user()->verUser($comentario->user_id)->nome }}" class="circle tooltipped">
    <p id="com-{{ $comentario->id }}-text">
        {{ $comentario->comentario }}
    </p>
</li>
@endforeach