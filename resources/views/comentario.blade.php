@foreach(App\Comentario::where('id_post', $id_post)->where('id', '>', $id_comentario)->get() as $comentario)
                                                    <li id="com-{{ $comentario->id }}" class="collection-item avatar com-{{ $comentario->id_post }}" style="height: auto; min-height:65px;max-height: 100%" data-id="{{ $comentario->id }}">
                                    
                                                         @if(Auth::user()->id == $comentario->id_user) 
            <a href="#modalExcluirComentario" onclick="excluirComentario({{ $comentario->id_post }}, {{ $comentario->id }})" class="wino"><i class="mdi-navigation-close right tiny"></i></a>
          
            @endif
                                    <img src="{{ App\User::avatar($comentario->id_user) }}" data-tooltip="Este é {{ App\User::verUser($comentario->id_user)->nome }}" class="circle tooltipped">
                                    <p>{{ $comentario->comentario }}</p>
                                </li>
                                                    @endforeach     