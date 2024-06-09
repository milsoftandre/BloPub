

    @php $adminS = \App\Models\Settings::find(1); @endphp

        <div class="post d-flex flex-column-fluid" id="kt_post">

            <div id="kt_content_container" class="container-xxl">

                <div class="card mb-5 mb-xl-8">


                    <div class="card-body py-2">
                        <table class="table align-middle mb-0 table-hover">
                        @foreach ($settings['form'] as $fname => $field)
                        <tr class=" fi_{{$fname}}">

                            <td>
                                <span>{{ $settings['attr'][$fname] }}</span>
                            </td>
                            <td>
                                @if($field=='text')

                                    @if($fname!='price' && $fname!='cycle')
                                        {{ $model->$fname }}
                                    @endif


                                        @if($fname=='cycle')
                                            @if($model->cycle_status==0)
                                            {{ ($model->$fname)?$model->$fname.' дней':'--' }}
                                                <a href="#" class="stoptaskci btn btn-light mt-2 btn-sm" v="{{$model->id}}">Остановить</a>
                                            @endif
                                                @if($model->cycle_status==1)
                                                    {{$settings['attr']['date_cycle']}} {{ $model->date_cycle }}
                                                    <a href="#" class="stoptaskci btn btn-light mt-2 btn-sm" v="{{$model->id}}">Остановить</a>
                                                @endif
                                                @if($model->cycle_status>1)

                                                    @if($model->cycle)
                                                    <a href="#" class="starttaskci btn btn-light mt-2 btn-sm" v="{{$model->id}}">Возобновить каждые {{$model->cycle}} дней</a>
                                                    @endif
                                                    @if($model->date_cycle && $model->date_cycle!='0000-00-00 00:00:00')
                                                        <a href="#" class="starttaskci btn btn-light mt-2 btn-sm" v="{{$model->id}}">Возобновить каждый {{$model->date_cycle}} день</a>
                                                    @endif
                                                @endif
                                        @endif

                                    @if($fname=='price')
                                            {{ $model->$fname }} @if (Auth::user()->type=='0' || Auth::user()->type=='1') (<span class="commissionField">0</span>) @endif {{$adminS->currency}}


                                    @endif
                                @endif
                                    @if($field=='textarea')
                                        {{ nl2br($model->$fname) }}
                                    @endif
                                    @if($field=='date')
                                        {{ explode(" ",$model->$fname)[0] }}
                                    @endif

                                        @if(is_array($field) && @$field[0][$model->$fname])
                                            {{ $field[0][$model->$fname] }}
                                        @endif
                            </td>

                        </tr>
                        @endforeach
                        </table>
                            <div class="row mb-6">

                                <div class="col-lg-8 fv-row">

                                    <table>

                                        @foreach ($model->files as $file)
                                            <tr class="del{{$file->id}}" >
                                                <td>
                                                    <a href="{{asset('upload/tasks/'.$file->name)}}">{{ (strpos($file->name,"--"))?explode("--",$file->name)[1]:$file->name}}</a> </td>
                                                <td><a href="{{ route('delfiles',['id'=>$file->id]) }}" class="btn-sm delfiles" v="{{$file->id}}"><i class="fas fa-trash"></i></a> </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>

                            </div>




                    </div>


                </div>
                <div class="accordion accordion-flush py-2" id="accordionFlushExample">
                @if(\App\Models\Logs::where('task_id',$model->id)->count()>0)

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Изменения - {{\App\Models\Logs::where('task_id',$model->id)->orderBy('id','desc')->first()->created_at}}
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <table class="table align-middle mb-0 table-hover">
                                        @foreach (\App\Models\Logs::where('task_id',$model->id)->get() as $log)
                                            <tr>
                                                <td>{{$log->employeesid->name}}</td>
                                                <td>{{$log->text}}</td>
                                                <td>{{$log->created_at}}</td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                            </div>
                        </div>



                @endif

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne">
                                Комментарии
                            </button>
                        </h2>
                        <div id="flush-collapseOne2" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <div class="chat-content" style="margin-left: 0px;overflow-y: auto; height: 300px;">




                                </div>
                                <div class="clearfix"></div> <br><br><br><br><br><br>
                                <form id="komform">
                                    <div class="chat-footer d-flex align-items-center" style="left: 0px;">

                                        <div class="flex-grow-1 pe-2">
                                            <div class="input-group">
                                                <input type="text" id="textmes" class="form-control" placeholder="Отправить сообщение">
                                            </div>
                                        </div>
                                        <div class="chat-footer-menu"> <a href="javascript:;" onclick="$('#komform').submit(); return false;"><i class="bx bx-send"></i></a>

                                        </div>

                                    </div></form>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>

                </div>




            </div>
        </div>

<script>

    new PerfectScrollbar('.chat-content');

    $.get( '{{ route('commentmes',['task_id'=>$model->id]) }}', function( data ) {
        $('.chat-content').html(data);
    });


        $('#komform').submit(function(){
            var thistext = $("#textmes").val();
            $("#textmes").val('');
            $.get( '{{ route('commentsend',['task_id'=>$model->id]) }}&text='+thistext, function( data ) {
                $.get( '{{ route('commentmes',['task_id'=>$model->id]) }}', function( data ) {
                    $('.chat-content').html(data);
                });
            });
            return false;
        });


    $('.stoptaskci').click(function(){
        var thisB = $(this);
        var thisV = $(this).attr('v');
        $.get( "{{ route('ch',['stop'=>1]) }}&id="+thisV, function( data ) {
            thisB.remove();
        });
        return false;
    });
    $('.starttaskci').click(function(){
        var thisB = $(this);
        var thisV = $(this).attr('v');
        $.get( "{{ route('ch',['start'=>1]) }}&id="+thisV, function( data ) {
            thisB.remove();
        });
        return false;
    });

    $('.delfiles').click(function(){
    var thisUrl = $(this).attr('href');
    var thisV = $(this).attr('v');
        $.get( thisUrl, function( data ) {
             $( ".del"+thisV ).remove();

        });
    return false;
    });

    if($('.make_id').val()=='0'){ $( ".fi_rek" ).hide(); }
    $('.make_id').change(function(){
    var thisV = $(this).val();
    if(thisV=='0'){
    $( ".fi_rek" ).hide();
    }else {
    $( ".fi_rek" ).show();
    }
    });




    if({{$model->make_id}}=='0'){
    $('.commissionField').text((({{$model->price}}*({{$adminS->commissionnone}}/100))+ + {{$model->price}}).toFixed(2));
    }else {
    $('.commissionField').text(({{$model->price}}*({{$adminS->commission}}/100)+ + {{$model->price}}).toFixed(2));
    }



</script>