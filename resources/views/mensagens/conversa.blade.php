@foreach($conversas as $conversa)
<section class="mensagem" id="mensagem-{{ $conversa->id }}">

    <p class="email-subject truncate">{{$conversa->assunto}}</p>
    <hr class="grey-text text-lighten-2">
    <div class="email-content-wrap" style="overflow-x: hidden">
        <div class="row">
            <div class="col s10 m10 l10">
                <ul class="collection">
                    <li class="collection-item avatar">
                        <span class="circle light-blue">{{\auth()->user()->verUser($conversa->rem_idetente)->name[0]}}</span>
                        <span class="email-title">{{\auth()->user()->verUser($conversa->rem_idetente)->name}}</span>
                        <p class="truncate grey-text ultra-small"><b>Para:</b> {{\auth()->user()->verUser($conversa->destinatario_id)->name}}</p>
                        <p class="grey-text ultra-small">{{ Carbon\Carbon::createFromTimeStamp(strtotime($conversa->created_at))->diffForHumans()}}</p>
                    </li>
                </ul>
            </div>
            <div class="col s2 m2 l2 email-actions">
                <a><span onclick="delMensagem({{$conversa->id}})" style="cursor: pointer"><i class="mdi-action-delete tooltipped" data-tooltip='Excluir' data-position='bottom'></i></span></a>
                @if(isset($archive))
                <a><span onclick="desarquivarMensagem({{$conversa->id}})"><i class="mdi-navigation-close tooltipped" data-tooltip='Arquivar' data-position='bottom' style="cursor: pointer"></i></span></a>
                @else
                <a><span onclick="arquivarMensagem({{$conversa->id}})"><i class="mdi-content-archive tooltipped" data-tooltip='Arquivar' data-position='bottom' style="cursor: pointer"></i></span></a>
                @endif
            </div>
        </div>
        <div class="email-content">
            <div class="row">
                <div class="col s12">

                    @if($conversa->midia)
                    <div class="col s6">
                        <h6>Mídia em anexo</h6>
                        <hr class="divider col s12">
                        @if(substr_count($conversa->midia, 'imagens'))
                        <a href="{{url($conversa->midia)}}" data-lightbox="Imagem enviada por {{\auth()->user()->verUser($conversa->rem_idetente)->name}}" style="margin-bottom: 10px;padding-left: 0;width: 80px">
                            <img src="{{url($conversa->midia)}}" alt="" class="responsive-img valign img-rounded col s10">
                        </a>
                        @else 
                        <a href="{{url($conversa->midia)}}" data-lightbox="Imagem enviada por {{\auth()->user()->verUser($conversa->rem_idetente)->name}}" style="margin-bottom: 10px;padding-left: 0;width: 80px">
                            <video src="{{url($conversa->midia)}}" alt="" class="video-container col s10">
                        </a>
                        @endif
                    </div>
                    @endif
                    @if($conversa->doc)

                    <div class="row">
                        <h6>Documento anexado</h6>
                        <hr class="divider col s12">
                        <div class="col s4">
                            <a href="{{url($conversa->doc)}}" class="col s10">
                                @if(substr_count($conversa->doc, '.docx'))
                                <img class="responsive-img" src="{{url('images/mensagens/office-word.png')}}">
                                @elseif(substr_count($conversa->doc, '.ppt') or (substr_count($conversa->doc, '.ppt')))
                                <img class="responsive-img" src="{{url('images/mensagens/office-ppt.png')}}">
                                @elseif(substr_count($conversa->doc, '.xls'))
                                <img class="responsive-img" src="{{url('images/mensagens/office-xls.png')}}">                                
                                @elseif(substr_count($conversa->doc, '.pdf'))
                                <img class="responsive-img" src="{{url('images/mensagens/pdf.png')}}">                                
                                @elseif(substr_count($conversa->doc, '.txt'))
                                <img class="responsive-img" src="{{url('images/mensagens/txt.png')}}">                                
                                @else(substr_count($conversa->doc, '.txt'))
                                <img class="responsive-img" src="{{url('images/mensagens/naotem.png')}}">  
                                @endif
                                Vizualizar online
                            </a>
                        </div>
                        <div class="col s8">
                            <a href="{{url($conversa->doc)}}">
                                <div class="card-panel info" style="color: black">
                                    Clique aqui para baixar o documento. Lembre-se de que não nos responsabilizamos pela existência de vírus em arquivos compartilhados.
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="col s12" style="margin-top: 30px">
                        {{$conversa->msg}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach
@if(empty($conversas[0]))
<div class="container">
    <div class="collection">
        <div class="collection-item">
            Não há mensagens neste tópico!
        </div>
    </div>
</div>
@endif
