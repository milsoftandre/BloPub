@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')

    @php $adminS = \App\Models\Settings::find(1); @endphp

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ $settings['title'] }}</div>

            <div class="ps-3">
                {{ $rows->count() }} {{__('tasks.rec')}}
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">

                        <div class="col-md-12">
                            {{ Form::open(['route' => ['tasks.index'],'method' => 'get']) }}

                            <div class="row">
                                <div class="col-md-9">
                            <div class="row">


                            @foreach ($settings['search'] as $fname => $field)

                                <div class="col-md-3 pt-2">
                                        @if($field=='text')
                                            {{ Form::text($fname, $request->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control']) }}
                                        @endif
                                        @if(is_array($field))
                                            {{ Form::select($fname, $field[0], $request->$fname,$field[1]) }}
                                        @endif

                                    </div>
                            @endforeach

                                        <div class="col-md-3 pt-2">
                                            {{ Form::date('date_from', $request->date_from, ['placeholder'=> 'Дата от', 'class'=>'form-control']) }}
                                        </div>
                                        <div class="col-md-3 pt-2">
                                            {{ Form::date('date_to', $request->date_to, ['placeholder'=> 'Дата до', 'class'=>'form-control']) }}
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-3  pt-2" right" style="text-align: right;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('tasks.index') }}" class="btn btn-danger btn-sm"> {{__('tasks.indexcs')}}  </a><button type="submit" class="btn btn-primary btn-sm">
                                <span class="indicator-label"> {{__('tasks.indexse')}}  </span></span>
                            </button>
                                        @if ($settings['isAdd'] && Auth::user()->type != 2)
                                            <a href="{{ route('tasks.create') }}" class="btn btn-warning btn-sm">{{ $settings['buttons']['add'] }}</a>
                                        @endif
                                    </div>

                        </div>

                            </div>
                            {{ Form::close() }}
            </div>
        </div>
                </div>
            </div>
        </div>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="">

                        <div class="">

                            <div hidden="true" class="showCbPanel">
                                {{ Form::open(['route' => ['updatech'],'method' => 'get','id' => 'updatech']) }}
                                <div class="row">
                                <div class="col">
                                {{ Form::select('change_status', $settings['status'], '',[
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => __('tasks.statusselect'),
                    'data-kt-select2' => 'true',
                ]) }}
                                </div> <div class="col">
                                {{ Form::select('change_group', $groups, '',[
                    'class' => 'form-control form-select-solid form-select',
                    'prompt' => __('tasks.groupselect'),
                    'data-kt-select2' => 'true',
                ]) }}
                                </div> <div class="col">
                                    <button type="submit" class="btn btn-primary changePanel">
                                        <span class="indicator-label"> {{__('tasks.indexchange')}} </span></span>
                                    </button>

                                </div>
                                </div>
                                {{ Form::close() }}
                                @if (Auth::user()->type == 0)

                                {{ Form::open(['route' => ['updatech'],'method' => 'get','id' => 'del']) }}
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-warning changePanel">
                                            <span class="indicator-label"> Удалить </span></span>
                                        </button>
                                    </div>
                                </div>
                                {{ Form::close() }}

                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="card-body py-3">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover">
                                <thead class="table-light">
                                <tr class="">
                                    @if ($settings['isCheckbox']==5)
                                    <th class="w-25px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input cheboxTable" id="select-all" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-13-check">
                                        </div>
                                    </th>
                                    @endif
                                    @foreach ($settings['table'] as $k=>$t)
                                        <th>
                                            {{ $settings['attr'][$t] }}
                                        </th>
                                    @endforeach
                                        @if (Auth::user()->type != 2)
                                    <th class="min-w-100px text-end">{{__('tasks.act')}}</th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    @if ($settings['isCheckbox'])
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input widget-13-check cheboxTable" type="checkbox" name="ids[]" value="{{$row->id}}">
                                        </div>
                                    </td>
                                    @endif
                                    @foreach ($settings['table'] as $k=>$t)
                                    <td data-href="{{ route('tasks.show',$row->id) }}" data-bs-toggle="modal" data-bs-target="#exampleLargeModal" style="cursor: pointer">
                                        @php $comC = $row->comments->count(); @endphp
                                        @if ($t=='name' && $comC>0)
                                        <span class="alert-warning card-img" style="padding: 3px;">{{$comC}}</span>
                                        @endif
                                        @php $data = str_replace("_","",$t) @endphp

                                        @if ($t=='status')<span class="badge {{$settings['status_class'][$row->$t]}}">@endif
                                            @if ($t=='price')
                                            {{number_format($row->price, 2, ',', ' ')}}
                                            @endif
                                            @if ($t!='price')
                                        {{ (strpos($t.'-',"_id"))?(((Session::get('locale')=='en') && @$row->$data->name_en)?$row->$data->name_en:(($row->$t!=0)?((@$row->$data->name)?@$row->$data->name:''):__('tasks.out'))):((strpos('-'.$t.'-',"date"))?date('d.m.Y', strtotime($row->$t)):(($t=='status')?$settings['status'][$row->$t]:Str::limit($row->$t, 20))) }}
                                            @endif
                                        @if ($t=='status')</span>@endif

                                        @if ($t=='price')
                                            {{$adminS->currency}}
                                        @endif
                                        @if ($t=='status' && Auth::user()->type==1 && $row->$t==2 && $row->make_id)

                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>3]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.work')}}
                                            </a>

                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>5]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.pay')}}
                                            </a>
                                        @endif

                                        @if(!$row->make_id)



                                            @if ($t=='status' && $row->$t<=3)
                                                <br><a href="{{ route('ch',['id'=>$row->id,'status'=>5]) }}" class="btn btn-light mt-2 btn-sm">
                                                    {{__('tasks.pay')}}
                                                </a>
                                            @endif

                                        @endif

                                        @if ($t=='status' && Auth::user()->type==2 && $row->$t==0)
                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>1]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.getwork')}}
                                            </a>
                                        @endif

                                        @if ($t=='status' && Auth::user()->type==2 && $row->$t==1)
                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>2]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.done')}}
                                            </a>
                                        @endif
                                        @if ($t=='status' && Auth::user()->type==2 && $row->$t==3)
                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>2]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.done')}}
                                            </a>
                                        @endif

                                        @if ($t=='status' && Auth::user()->type!=2 && $row->$t==5)
                                            <br><a href="{{ route('ch',['id'=>$row->id,'status'=>6]) }}" class="btn btn-light mt-2 btn-sm">
                                                {{__('tasks.status6')}}
                                            </a>
                                        @endif

                                        @if ($t=='make_id' && Auth::user()->id!=$row->make_id && $row->make_id>0)
                                            <a href="{{ route('chat',['uid'=>$row->make_id]) }}" class="hidden">

                                            </a>
                                        @endif
                                    </td>

                                    @endforeach
                                        @if (Auth::user()->type != 2)
                                    <td class="text-end">
                                        <form action="{{ route('tasks.destroy',$row->id) }}" method="POST">

                                            @if ($row->make_id==Auth::user()->id || Auth::user()->type == 0)
                                                <a href="{{ route('tasks.copy',['id'=>$row->id]) }}" class="btn btn-light btn-sm">
                                                    <span class="bx bx-copy"></span>
                                                </a>
                                            @endif

                                                @if ($settings['isEdit'] && Auth::user()->type != 2)
                                        <a href="{{ route('tasks.edit',$row->id) }}" class="btn btn-light btn-sm">
                                            <span class="bx bx-edit"></span>
                                        </a>
                                                @endif
                                            @csrf
                                            @method('DELETE')

                                                @if ($settings['isDel'] && Auth::user()->type != 2 && $row->status!=6)
                                            <button type="submit" class="btn btn-light  btn-sm"><span class="bx bx-trash"></span></button>
                                                @endif
                                        </form>
                                    </td>
                                        @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                            {{ $rows->appends($request->all())->links('base.pages') }}
                    </div>
                </div>

    </div>
        </div>




@endsection

@section('pageScript')
    $( document ).ready(function() {

    $('body').on('click', '[data-bs-toggle="modal"]', function(){

    if($(this).attr('data-bs-target')!='#exampleLargeModal2'){
        $($(this).data("bs-target")+' .modal-body').html('Загрузка...');
        $($(this).data("bs-target")+' .modal-body').load($(this).data("href"));
        }
    });

    $('#updatech').submit(function(){
    var thisUrl = $(this).attr('action');
    var thisV = $(".cheboxTable").serialize();
    var thisV2 = $(this).serialize();

        $.get( thisUrl+"?i=1&"+thisV+"&"+thisV2, function( data ) {
    document.location.reload();
        });
    return false;
    });

    $('#del').submit(function(){
    var thisUrl = $(this).attr('action');
    var thisV = $(".cheboxTable").serialize();
    var thisV2 = $(this).serialize();

    $.get( thisUrl+"?i=1&"+thisV+"&del=yes", function( data ) {
    document.location.reload();
    });
    return false;
    });

    $('.cheboxTable').change(function(){

    var checkboxes = $('.cheboxTable');
    var isCh = 0;
    checkboxes.each(function(){
    if($(this).prop('checked')) {
    isCh = 1;
    }
    });

    if(isCh==1){

    $('.showCbPanel').removeAttr('hidden');
        }else {
    $('.showCbPanel').attr('hidden','false');
        }
    });


    });

    $('#select-all').click(function(event) {
    if(this.checked) {
    // Iterate each checkbox
    $(':checkbox').each(function() {
    this.checked = true;
    });
    } else {
    $(':checkbox').each(function() {
    this.checked = false;
    });
    }
    });
@endsection