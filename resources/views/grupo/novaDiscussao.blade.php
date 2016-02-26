@foreach($discussoes as $discussao)
    <section class="discussao blog col s12" style="margin-top: 30px" id="discussao-{{$discussao->id}}" data-id='{{$discussao->id}}'>
        <div class="blog col s6" style="margin-top: 5px">
            <div class="card">
                <div class="card-content">


                    <h4 class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4">{{ $discussao-> titulo}}</a></h4>
                    <p class="row">
                        <span class="left">{{ $discussao-> assunto}}</span>
                    </p>
                    <blockquote style="border-color:#0097a7">
                        <div style="height: auto;max-height: 300px; overflow:auto">
                            <p class="blog-post-content" style="padding-right: 10px">{{ $discussao-> discussao}}</p>
                        </div>
                    </blockquote>
                    <div class="row">
                        <div class="col s2">
                            <img src="{{ App\User::Avatar($discussao->id_autor)}}" alt="Este é {{ App\User::verUser($discussao->id_autor)->nome }}." class="circle responsive-img valign profile-image">
                        </div>
                        <div class="col s9"> Por <a href="{{ url(App\User::verUser($discussao-> id_autor)-> username)}}">{{ App\User::verUser($discussao->id_autor)->nome }}</a></div>
                            <a href="#modalExcluirDiscussao" onclick="excluirDiscussao({{ $discussao-> id}})" class="wino"><i class="mdi-action-delete waves-effect waves-light " style="opacity: 0.7"></i></a>                                                                
                    </div>

                </div>
            </div>
        </div>
        <div class="col s1"><i class="mdi-hardware-keyboard-arrow-right center medium" style="margin-top:200px; opacity: 0.5"></i></div>

        <!--DISCUSSÃO POST ("comentários") aqui-->
        <div class="card-reveal" style="height: auto; min-height: 80px">                                            
            <span class="card-title grey-text text-darken-4"> Discussões</span>
            <div class="collection" style="height: auto; max-height: 460px; overflow-y: auto">
                <ul class="collection"  style="margin-top:0px" id="com-disc-{{ $discussao-> id}}">

                 <!--NÃO ENCONTROU DISCUSSOES-->
                    Essa discussão ainda está vazia. Comece agora! 
                                                            

                </ul>

                <div class="left row white" style="bottom: 0px; width: 105%">
                    <div class="col s12">
                        <div class="input-field col s12">
                            <form method="POST" onsubmit="return discutir({{ $discussao-> id}}, {{ $grupo-> id}});" >
                                <input type="hidden" name="id_post" value="{{ $discussao-> id}}" >
                                <input id="comentario-{{ $discussao-> id}}" type="text" class="validate" autocomplete="off">
                                <label for="comment" class="">Discutir</label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach