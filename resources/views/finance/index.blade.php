@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $settings['title'] }}</div>

        <div class="ps-3">
            {{ $rows->count() }} {{__('finance.rec')}}
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
                            {{ Form::open(['route' => ['finance.index'],'method' => 'get']) }}

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

                                <div class="col-md-3  pt-2 right" style="text-align: right;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('finance.index') }}" class="btn btn-danger btn-sm"> {{__('finance.bc')}} </a><button type="submit" class="btn btn-primary btn-sm">
                                <span class="indicator-label"> {{__('finance.bs')}} </span></span>
                            </button>
                                        @if ($settings['isAdd'])
                                            <a href="{{ route('finance.create') }}" class="btn btn-warning btn-sm">{{ $settings['buttons']['add'] }}</a>
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


                    <div class="card-body py-3">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                {{ $message }}
                            </div>
                        @endif
                            @php $adminS = \App\Models\Settings::find(1); @endphp
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                <tr class="">
                                    @if ($settings['isCheckbox'])
                                    <th class="w-25px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-13-check">
                                        </div>
                                    </th>
                                    @endif
                                    @foreach ($settings['table'] as $k=>$t)
                                        <th>
                                            {{ $settings['attr'][$t] }}
                                        </th>
                                    @endforeach
                                        @if (Auth::user()->type==0)
                                    <th class="min-w-100px text-end">{{__('finance.act')}}</th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rows as $row)
                                <tr>
                                    @if ($settings['isCheckbox'])
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input widget-13-check" type="checkbox" value="1">
                                        </div>
                                    </td>
                                    @endif
                                    @foreach ($settings['table'] as $k=>$t)
                                            <td>

                                                @php $data = str_replace("_","",$t) @endphp
                                                @if ($t=='type')<span class="badge {{$settings['type_class'][$row->$t]}}">@endif

                                                    @if ($t=='price')
                                                        {{number_format($row->price, 2, ',', ' ')}}
                                                    @endif
                                                    @if ($t!='price')
                                                    {{ (strpos($t.'-',"_id") && $row->$t!=0)?$row->$data->name:((strpos('-'.$t.'-',"date"))?date('d.m.Y', strtotime($row->$t)):(($t=='type')?$settings['type'][$row->$t]:$row->$t)) }}
                                                    @endif
                                                    @if ($t=='type')</span>@endif
                                                @if ($t=='price')
                                                    {{$adminS->currency}}
                                                @endif




                                            </td>
                                    @endforeach

                                        @if (Auth::user()->type==0)
                                    <td class="text-end">
                                        <form action="{{ route('finance.destroy',$row->id) }}" method="POST">
                                            @if ($settings['isShow'])
                                        <a href="{{ route('finance.show',$row->id) }}" class="btn btn-light">
                                            <i class="fas fa-file"></i>
                                        </a>
                                            @endif
                                                @if ($settings['isEdit'])
                                        <a href="{{ route('finance.edit',$row->id) }}" class="btn btn-light">
                                            <span class="bx bx-edit"></span>
                                        </a>
                                                @endif
                                            @csrf
                                            @method('DELETE')

                                                @if ($settings['isDel'])
                                            <button type="submit" class="btn btn-light"><span class="bx bx-trash"></span></button>
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
    </div>

@endsection