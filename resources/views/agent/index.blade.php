@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $settings['title'] }}</div>

        <div class="ps-3">
            {{ $rows->count() }} {{__('agent.rec')}}
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
        <div>
            <div id="kt_content_container" class="container-xxl">
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">

                        <div class="col-md-12">
                            {{ Form::open(['route' => ['agent.index'],'method' => 'get']) }}

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">


                                        @foreach ($settings['form'] as $fname => $field)

                                            <div class="col">
                                                @if($field=='text')
                                                    {{ Form::text($fname, $request->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control']) }}
                                                @endif
                                                @if(is_array($field))
                                                    {{ Form::select('size', $field[0], $request->$fname,$field[1]) }}
                                                @endif

                                            </div>
                                        @endforeach
                                            <div class="col">
                                                {{ Form::checkbox('status', 1, $request->status) }} {{__('employee.dele')}}
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-3 right" style="text-align: right;">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('agent.index') }}" class="btn btn-danger btn-sm"> {{__('agent.bc')}} </a><button type="submit" class="btn btn-primary btn-sm">
                                            <span class="indicator-label"> {{__('agent.bs')}} </span></span>
                                        </button>
                                        @if ($settings['isAdd'])
                                            <a href="{{ route('agent.create') }}" class="btn btn-warning btn-sm">{{ $settings['buttons']['add'] }}</a>
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
                                    @foreach ($settings['table_agent'] as $k=>$t)
                                        <th>
                                            {{ $settings['attr'][$t] }}
                                        </th>
                                    @endforeach
                                        @if(!Auth::user()->employees_id)
                                    <th class="min-w-100px text-end">{{__('agent.act')}}</th>
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
                                        @foreach ($settings['table_agent'] as $k=>$t)
                                            <td>
                                                {{ $row->$t }}

                                            </td>
                                        @endforeach


                                            @if(!Auth::user()->employees_id)
                                        <td class="text-end">
                                            <form action="{{ route('agent.destroy',$row->id) }}" method="POST">
                                                @if ($settings['isShow'])
                                                    <a href="{{ route('agent.show',$row->id) }}" class="btn btn-light">
                                                        <i class="fas fa-file"></i>
                                                    </a>
                                                @endif
                                                @if ($settings['isEdit'])
                                                    <a href="{{ route('agent.edit',$row->id) }}" class="btn btn-light">
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