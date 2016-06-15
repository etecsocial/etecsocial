@foreach(array_reverse($msgs) as $chat)  
@if($chat['id_remetente'] == auth()->user()->id)
<div class="chatn clear"></div>
<div class="chatm from-me" data-date="{{ $chat['data'] }}">
    {{ $chat['msg'] }}
</div>
@else
<div class="chatn clear"></div>
<div class="chatm from-them" data-date="{{ $chat['data'] }}">
    <img src="{{ auth()->user()->avatar($id_user) }}" class="circle photo">
    {{ $chat['msg'] }}
</div>
@endif
@endforeach                               
