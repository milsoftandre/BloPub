@foreach ($mes as $me)
    <div class="chat-content-{{(Auth::user()->id==$me->employees_id)?'rightside':'leftside'}}">
        <div class="d-flex">
            @if (Auth::user()->id!=$me->employees_id)
                <img src="{{($me->from->file)?asset('upload/images/'.$me->from->file):'assets/images/avatars/avatar-2.png'}}" width="48" height="48" class="rounded-circle" alt="" />
            @endif
            <div class="flex-grow-1 {{(Auth::user()->id==$me->employees_id)?'me-2':'ms-2'}}">
                <p class="mb-0 chat-time {{(Auth::user()->id==$me->employees_id)?' text-end':''}}">{{(Auth::user()->id!=$me->employees_id)?$me->from->name:'вы'}}, {{$me->created_at}}</p>
                <p class="chat-{{(Auth::user()->id==$me->employees_id)?'right':'left'}}-msg">{{$me->text}}</p>
            </div>
        </div>
    </div>
@endforeach

