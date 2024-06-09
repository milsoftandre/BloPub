@extends('base.base')

@section('pageTitle', __('chat.title'))

@section('content')


    <div class="chat-wrapper my-5">
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <div class="d-flex align-items-center">
                    <div class="chat-user-online">
                        <img src="{{(Auth::user()->file)?asset('upload/images/'.Auth::user()->file):'assets/images/avatars/avatar-2.png'}}" width="45" height="45" class="rounded-circle" alt="">
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <p class="mb-0">{{Auth::user()->name}}</p>
                    </div>
                    <div class="dropdown">
                        <div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-horizontal-rounded"></i>
                        </div>
                        <div class="dropdown-menu dropdown-menu-end" style="margin: 0px;"> <a class="dropdown-item" href="javascript:;">Настройки</a>
                            <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Информация</a>
                            <a class="dropdown-item" href="javascript:;">Enable Split View Mode</a>
                            <a class="dropdown-item" href="javascript:;">Keyboard Shortcuts</a>
                            <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Закрыть</a>
                        </div>
                    </div>
                </div>
                <div class="mb-3"></div>

            </div>
            <div class="chat-sidebar-content">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-Chats">

                        <div class="chat-list ps ps--active-y">
                            <div class="list-group list-group-flush">
                                @foreach ($rooms as $room)

                                <a href="{{ route('chat',['room_id'=>$room->id]) }}" class="removeroom{{$room->id}} list-group-item{{($room->id==$thisRoom)?' active':''}}">
                                    <div class="d-flex">
                                        <div class="chat-user{{((\Carbon\Carbon::parse(\App\Models\Employee::find($room->employees_id_from)->online_user)>\Carbon\Carbon::now())?'-online':'')}}">
                                            <img src="{{ ($room->employees_id_from==Auth::user()->id)?(($room->to->file)?asset('upload/images/'.$room->to->file):'assets/images/avatars/avatar-2.png'):(($room->from->file)?asset('upload/images/'.$room->from->file):'assets/images/avatars/avatar-2.png')}}" width="42" height="42" class="rounded-circle" alt="">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0 chat-title">{{ ($room->employees_id_from==Auth::user()->id)?$room->to->name:$room->from->name }}</h6>
                                            <p class="mb-0 chat-msg"><bottom href="#" class="delroom" v="{{$room->id}}">{{__('chat.del')}}</bottom> </p>
                                        </div>
                                        <div class="chat-time">{{$room->created_at}}</div>
                                    </div>
                                </a>
                                @endforeach

                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 300px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 167px;"></div></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-header d-flex align-items-center">
            <div class="chat-toggle-btn"><i class="bx bx-menu-alt-left"></i>
            </div>
            <div>
                <h4 class="mb-1 font-weight-bold">{{__('chat.title')}}</h4>
            </div>

        </div>

        <div class="chat-content">

        {{view('mes', compact('mes','thisRoom'))}}


        </div>
        <form id="chatform">
        <div class="chat-footer d-flex align-items-center">
            @if($thisRoom)
            <div class="flex-grow-1 pe-2">
                <div class="input-group">
                    <input type="text" id="textmes" class="form-control" placeholder="{{__('chat.mes')}}">
                </div>
            </div>
            <div class="chat-footer-menu"> <a href="javascript:;" onclick="$('#chatform').submit(); return false;"><i class="bx bx-send"></i></a>

            </div>
            @endif
        </div></form>
        <!--start chat overlay-->
        <div class="overlay chat-toggle-btn-mobile"></div>
        <!--end chat overlay-->
    </div>


@endsection

@section('pageScript')
new PerfectScrollbar('.chat-list');
new PerfectScrollbar('.chat-content');
@if($thisRoom)
function upChat(){
    $.get( '{{ route('chatmes',['room_id'=>$thisRoom]) }}', function( data ) {
        $('.chat-content').html(data);
            setTimeout(upChat,5000);
    });
}

$( document ).ready(function() {


    $('#chatform').submit(function(){
        var thistext = $("#textmes").val();
        $("#textmes").val('');
            $.get( '{{ route('chatsend',['room_id'=>$thisRoom]) }}&text='+thistext, function( data ) {
                $.get( '{{ route('chatmes',['room_id'=>$thisRoom]) }}', function( data ) {
                        $('.chat-content').html(data);
                });
            });
        return false;
    });

$('.delroom').click(function(){
    var thisV = $(this).attr('v');
    $.get( '{{ route('chatmes') }}?del='+thisV, function( data ) {
        $('.removeroom'+thisV).remove();
    });
    return false;
});

upChat();
upChatRead();
});
@endif
@endsection