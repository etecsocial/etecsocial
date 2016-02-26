@foreach($nots as $not)
                                 <li onclick="abrirPost({{ $not->action }})" class="nota collection-item avatar transparent" data-date="{{ $not->data }}">
                                    <img src="{{ App\User::avatar($not->id_rem) }}" alt="" class="circle">
                                    <span class="title">{{ App\User::verUser($not->id_rem)->nome }}</span>
                                    <small>
                                        <small>
                                        <p>{{ $not->texto }}</p>
                                        <i>{{ Carbon\Carbon::createFromTimeStamp(strtotime($not->created_at))->diffForHumans()  }}</i>
                                        @if(!$not->visto)
                                        <span class="new badge"></span>
                                        @endif
                                    </small>
                                       
                                    </small>
                                    
                                </li>
                                @endforeach

