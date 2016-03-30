<div class="row">
   <div class="col s10 m10 l10">
      <ul class="collection">
         <li class="collection-item avatar">
            <img src="{{ auth()->user()->avatar($user) }}" alt="" class="circle">
            <span class="email-title">{{ auth()->user()->verUser($user)->nome }}</span>
            @if(auth()->user()->verUser($user)->online)
            <p class="green-text ultra-small">Online</p>
            @endif
         </li>
      </ul>
   </div>
   <div class="col s2 m2 l2 email-actions">
      <a href="#!"><span><i class="mdi-content-reply"></i></span></a>
      <a href="#!"><span><i class="mdi-navigation-more-vert"></i></span></a>
   </div>
</div>
<div class="mensagens" style="max-height: 400px;overflow-y: scroll;">
   @foreach(array_reverse($msgs) as $chat)  
   @if($chat['id_remetente'] == auth()->user()->id)
   <div class="msg-enviada">
      {{ $chat['msg'] }}
   </div>
   <div class="clear"></div>
   @else
   <div class="msg-recebida">
      {{ $chat['msg'] }}
   </div>
   <div class="clear"></div>
   @endif
   @endforeach
</div>
<div class="divider"></div>
<div class="row">
   <div class="col s12">
      <div class="col s8">
         <textarea id="textarea1" class="materialize-textarea" style="padding-bottom: 0"></textarea>
      </div>
      <div class="col s4">
      </div>
   </div>
</div>