@foreach($nots as $not)
<li onclick="abrirPost({{ $not->action }})" class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
    <img src="{{ auth()->user()->avatar($not->rem_id) }}" alt="" class="circle">
    <span class="title">{{ auth()->user()->verUser($not->rem_id)->nome }}</span>
    <small>
      <small>
         <p>{{ $not->texto }}</p>
         <i>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</i>
         @if(!$not->visto)
         <span class="new badge"></span>
         @endif
      </small>
    </small>
</li>
@endforeach
