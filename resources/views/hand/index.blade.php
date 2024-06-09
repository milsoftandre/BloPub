@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $settings['title'] }}</div>

        <div class="ps-3">
            {{ $rows->count() }} {{__('hand.rec')}}
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
        <div>
            <div id="kt_content_container" class="container-xxl">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">   {{ Form::open(['route' => ['hand.index'],'method' => 'get']) }}
<div class="row">

                        <div class="col-md-9">
                            <div class="col">
                            @php
                                if(Auth::user()->employees_id){
                                $h = md5(Auth::user()->employees_id);
                                $i = Auth::user()->employees_id;
                                }else {
                                $h = md5(Auth::user()->id);
                                $i = Auth::user()->id;
                                }
                                    @endphp
                            Cтраница приглашения: <a href="http://104.248.167.68/work/1blo/register/{{$i}}/{{$h}}" onclick="copyToClipboard('#link'); return false;" id="link" target="_blank">http://104.248.167.68/work/1blo/register/{{$i}}/{{$h}}</a>
                            </div>
                                <div class="col">
                                {{ Form::checkbox('status', 1, $request->status) }} {{__('employee.dele')}}
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('hand.index') }}" class="btn btn-danger btn-sm"> {{__('client.bc')}} </a><button type="submit" class="btn btn-primary btn-sm">
                                <span class="indicator-label"> {{__('client.bs')}} </span></span>
                            </button>
                        @if ($settings['isAdd'])
                            <a href="{{ route('hand.create') }}" class="btn btn-sm btn-primary">{{ $settings['buttons']['add'] }}</a>
                        @endif
                            </div>
                        </div>

</div>{{ Form::close() }}
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
                                    <th class="min-w-100px text-end">{{__('hand.act')}}</th>
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
                                                {{ $row->$t }}


                                            </td>
                                        @endforeach

                                        <td class="text-end">
                                            <form action="{{ route('hand.destroy',$row->id) }}" method="POST">
                                                @if ($settings['isShow'])
                                                    <a href="{{ route('hand.show',$row->id) }}" class="btn btn-light">
                                                        <i class="fas fa-file"></i>
                                                    </a>
                                                @endif
                                                @if ($settings['isEdit'])
                                                    <a href="{{ route('hand.edit',$row->id) }}" class="btn btn-light">
                                                        <span class="bx bx-edit"></span>
                                                    </a>
                                                @endif
                                                @csrf
                                                @method('DELETE')

                                                @if ($settings['isDel'] && $row->id!=1)
                                                    <button type="submit" class="btn btn-light">
                                                        @if ($row->status!=1)
                                                        <span class="bx bx-trash"></span>
                                                        @endif
                                                            @if ($row->status!=0)
                                                                <span class="bx bx-redo"></span>
                                                            @endif
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
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