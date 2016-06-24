@foreach(array_reverse($msgs) as $chat)  
@if($chat['rem_idetente'] == auth()->user()->id)
<div class="chatn clear"></div>
<div class="chatm from-me" data-date="{{ $chat['data'] }}">
    {{ $chat['msg'] }}
</div>
@else
<div class="chatn clear"></div>
<div class="chatm from-them" data-date="{{ $chat['data'] }}">
    <img src="{{ auth()->user()->avatar($user_id) }}" class="circle photo">
    {{ $chat['msg'] }}
</div>
@endif
@endforeach                               
