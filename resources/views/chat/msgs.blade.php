<center id="morem"><a href="{{ url('chat/' . $id_user) }}"><small>Ver mais mensagens</small></center>
@foreach(array_reverse($msgs) as $chat)  
@if($chat['id_remetente'] == Auth::user()->id)
<div class="chatn clear"></div>
<div class="chatm from-me" data-date="{{ $chat['data'] }}">{{ $chat['msg'] }}</div>
@else
<div class="chatn clear"></div>
<div class="chatm from-them" data-date="{{ $chat['data'] }}"><img class="circle photo" alt="John Peter" src="{{ App\User::avatar($id_user) }}"> {{ $chat['msg'] }} </div>
@endif
@endforeach