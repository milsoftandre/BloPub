@php
    if(\App\Models\Rooms::where('employees_id_from',Auth::user()->id)->where('employees_id_to',1)->count()==0 && \App\Models\Rooms::where('employees_id_from',1)->where('employees_id_to',Auth::user()->id)->count() == 0){
       $thisRoom = \App\Models\Rooms::create([
           'employees_id_from' => Auth::user()->id,
           'employees_id_to' => 1
       ])->id;
   }else {

   if(\App\Models\Rooms::where('employees_id_from',Auth::user()->id)->where('employees_id_to',1)->count()){
   $thisRoom = @\App\Models\Rooms::where('employees_id_from',Auth::user()->id)->where('employees_id_to',1)->firstOrFail()->id;
   }else {
   $thisRoom = @\App\Models\Rooms::where('employees_id_from',1)->where('employees_id_to',Auth::user()->id)->firstOrFail()->id;
    }
   }
$mes = \App\Models\Messages::where('room_id',$thisRoom)->orderBy('id', 'ASC')->get();
$rooms = \App\Models\Rooms::orWhere('employees_id_from',Auth::user()->id)->orWhere('employees_id_to',Auth::user()->id)->get();

@endphp


    <div class="chat-wrapper my-5" style="height: 520px; margin-top: 0rem!important; margin-bottom: 0rem!important;">

        <div class="chat-content chat-contentAll" style="position: static; margin-left: 0px;  overflow: auto; display: flex;  flex-direction: column-reverse;">

        {{view('mes', compact('mes','thisRoom'))}}


        </div>
        <form id="chatformAll">
        <div class="chat-footer d-flex align-items-center" style="position: static;">
            @if($thisRoom)
            <div class="flex-grow-1 pe-2">
                <div class="input-group">
                    <input type="text" id="textmesAll" class="form-control" placeholder="{{__('chat.mes')}}">
                </div>
            </div>
            <div class="chat-footer-menu"> <a href="javascript:;" onclick="$('#chatformAll').submit(); return false;"><i class="bx bx-send"></i></a>

            </div>
            @endif
        </div></form>
        <!--start chat overlay-->
        <div class="overlay chat-toggle-btn-mobile"></div>
        <!--end chat overlay-->
    </div>

<script>
  


//new PerfectScrollbar('.chat-contentAll');
@if($thisRoom)
function upChatAll(){
    $.get( '{{ route('chatmes',['room_id'=>$thisRoom]) }}', function( data ) {
        $('.chat-contentAll').html(data);
            setTimeout(upChatAll,5000);
    });
}
var thisTitle = document.getElementsByTagName('title')[0].textContent;
function upChatNew(){
    $.get( '{{ route('chatmes',['new'=>1]) }}', function( data ) {
        if(data=='1'){
            console.log('new');
            var a = document.getElementsByTagName('title')[0];
            a.innerHTML = '!!! Новое сообщение';
            $('.messcount').show();
            new Audio('{{ asset('assets/audio_file.mp3')  }}').play();
            setTimeout(function(){ var a = document.getElementsByTagName('title')[0]; a.innerHTML = thisTitle; }, 1000);
            upChatRead();
            
        }else {

                var a = document.getElementsByTagName('title')[0];

                a.innerHTML = thisTitle;
            $('.messcount').hide();

        }
        setTimeout(upChatNew,6000);
    });
}
function upChatRead(){
    $.get( '{{ route('chatmes',['room_id'=>$thisRoom]) }}&read=1', function( data ) {
    });
}
$( document ).ready(function() {


    $('#chatformAll').submit(function(){
        var thistext = $("#textmesAll").val();
$("#textmesAll").val('');
            $.get( '{{ route('chatsend',['room_id'=>$thisRoom]) }}&text='+thistext, function( data ) {
                $.get( '{{ route('chatmes',['room_id'=>$thisRoom]) }}', function( data ) {
                        $('.chat-contentAll').html(data);
                });
            });
        return false;
    });

    @if (Auth::user()->type!=0)
upChatAll();
    @endif
    upChatNew();
});

@endif
</script>
<style>
    .chat-contentAll::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .chat-contentAll {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>