@extends('base.base')

@section('pageTitle', __('menu.index'))

@section('content')

    @php $adminS = \App\Models\Settings::find(1);

    $date_from = ((@$request->date_from)?$request->date_from:date("Y-m-d", strtotime("-1 month")));
    $date_to = ((@$request->date_to)?$request->date_to:date("Y-m-d"));

    if(@$request->type==1){
        $date_from = date("Y-m-01",strtotime($date_from));
        }elseif($request->type==2){
        $date_from = date("Y-01-01",strtotime($date_from));
        }

    @endphp

    <div class="hidden-xs" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0">

                    <div class="col-md-12">
                        {{ Form::open(['route' => ['dashboard'],'method' => 'get']) }}

                        <div class="row">
                            <div class="col-md-10">

                                <div class="row">
                                    <div class="col">
                                        {{ Form::date('date_from', $date_from, ['placeholder'=> __('welcome.d1'), 'class'=>'form-control']) }}
                                    </div>
                                    <div class="col">
                                        {{ Form::date('date_to', $date_to, ['placeholder'=> __('welcome.d2'), 'class'=>'form-control']) }}
                                    </div>
                                    <div class="col">
                                        {{ Form::select('type', [ 0 => __('welcome.days'), 1=> __('welcome.mes'), 2=>__('welcome.years')], $request->type,[
                        'class' => 'form-control form-select form-select-solid',
                        'prompt' => 'Тип',
                        'data-kt-select2' => 'true',
                                        ]) }}

                                    </div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                    <div class="col"></div>
                                </div>
                            </div>

                            <div class="col-md-2 right" style="text-align: right;">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('dashboard') }}" class="btn btn-danger btn-sm"> {{__('finance.bc')}} </a><button type="submit" class="btn btn-primary btn-sm">
                                        <span class="indicator-label"> {{__('finance.bs')}} </span></span>
                                    </button>
                                </div>

                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid " id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            @php

            @endphp
            @if (Auth::user()->type==0)
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
														<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
														<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
														<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-900 fw-bolder fs-5 mb-2 mt-5">{{ number_format((\App\Models\Employee::sum('balance')), 2, ',', ' ') }} {{$adminS->currency}}</div>
                                <div class="fw-bold text-gray-400">{{__('welcome.allb')}}</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="black"></path>
														<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="black"></path>
														<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="black"></path>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-gray-100 fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::count() }}</div>
                                <div class="fw-bold text-gray-100">{{__('welcome.allt')}}</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('status',1)->count() }}</div>
                                <div class="fw-bold text-white">{{__('welcome.work')}}</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                    <div class="col-xl-3">
                        <!--begin::Statistics Widget 5-->
                        <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="black"></path>
														<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="black"></path>
													</svg>
												</span>
                                <!--end::Svg Icon-->
                                <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ number_format((\App\Models\Tasks::where('status',5)->sum('price')), 2, ',', ' ') }} {{$adminS->currency}}</div>
                                <div class="fw-bold text-white">{{__('welcome.sum')}}</div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Statistics Widget 5-->
                    </div>
                </div>

                <div class="card mb-5 mb-xl-8 bg-dark hidden-xs">
                    <div class="card-header border-0 pt-5">



                        <div class="col-md-12">
                            <script src="//cdn.jsdelivr.net/npm/chart.js"></script>
                            <canvas id="myChart"></canvas>
                            <script>
                                // === include 'setup' then 'config' above ===

                                const labels = [
                                    @php
                                    if($request->type==1){
                                        for ($i=0;$i<1000;$i++){
                                    echo "'".date('M Y', strtotime($date_from.' +'.$i.' month'))."'";
                                    if(strtotime($date_from.' +'.$i.' month')>=strtotime($date_to)){
                                    break;
                                    }else {
                                    echo ',';
                                    }
                                         }
                                    }elseif($request->type==2){
                                        for ($i=0;$i<1000;$i++){
                                    echo "'".date('Y', strtotime($date_from.' +'.$i.' year'))."'";
                                    if(strtotime($date_from.' +'.$i.' year')>=strtotime($date_to)){
                                    break;
                                    }else {
                                    echo ',';
                                    }
                                         }
                                    }else {
                                        for ($i=0;$i<1000;$i++){
                                    echo "'".date('d.m.Y', strtotime($date_from.' +'.$i.' day'))."'";
                                    if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                    break;
                                    }else {
                                    echo ',';
                                    }
                                         }

                                    }
                                    @endphp

                                ];
                                const data = {
                                    labels: labels,
                                    datasets: [{
                                        label: '{{__('welcome.k')}}',
                                        backgroundColor: 'rgb(255, 255, 255)',
                                        borderColor: 'rgb(255, 255, 255)',
                                        data: [
                                            @php
                                                if($request->type==1){
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id', '=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' month')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' month'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' month')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }
                                                }elseif($request->type==2){
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id', '=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' year')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' year'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' year')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }
                                                }else {
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id', '=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' day')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' day'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }
                                                }
                                            @endphp

                                        ],
                                    },{
                                        label: '{{__('welcome.i')}}',
                                        backgroundColor: 'rgb(255,0,0)',
                                        borderColor: 'rgb(255,0,0)',
                                        color: '#fff',
                                        data: [
                                            @php
                                                if($request->type==1){
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".\App\Models\Tasks::where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' month')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' month'))])->count()."'";
                                            if(strtotime($date_from.' +'.$i.' month')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                                }elseif($request->type==2){
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".\App\Models\Tasks::where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' year')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' year'))])->count()."'";
                                            if(strtotime($date_from.' +'.$i.' year')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                                }else {
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".\App\Models\Tasks::where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' day')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' day'))])->count()."'";
                                            if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                            }
                                            @endphp

                                        ],
                                    }]
                                };
                                const config = {
                                    type: 'line',
                                    data: data,
                                    options: {
                                        legend: {
                                            labels: {
                                                fontColor: 'white'
                                            }
                                        }
                                    }
                                };
                                const myChart = new Chart(
                                    document.getElementById('myChart'),
                                    config
                                );
                            </script>

                        </div>
                    </div>
                </div>
            @endif

            @if (Auth::user()->type==1)

            <div class="row g-5 g-xl-8">
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
														<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
														<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
														<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-gray-900 fw-bolder fs-5 mb-2 mt-5">
                                @if(Auth::user()->employees_id)
                                    {{ number_format((\App\Models\Employee::find(Auth::user()->employees_id)->balance), 2, ',', ' ') }}
                                @endif
                                @if(!Auth::user()->employees_id)
                                    {{ number_format((Auth::user()->balance), 2, ',', ' ') }}
                                @endif
                                    {{$adminS->currency}}
                            </div>
                            <div class="fw-bold text-gray-400">{{__('welcome.b')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="black"></path>
														<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="black"></path>
														<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-gray-100 fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->count() }}</div>
                            <div class="fw-bold text-gray-100">{{__('welcome.allt')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',1)->count() }}</div>
                            <div class="fw-bold text-white">{{__('welcome.work')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="black"></path>
														<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ number_format((\App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',5)->sum('price')), 2, ',', ' ') }} {{$adminS->currency}}</div>
                            <div class="fw-bold text-white">{{__('welcome.done')}}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>

                <!-- 9 -->

                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',2)->count() }}</div>
                            <div class="fw-bold text-white">На проверке</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',4)->count() }}</div>
                            <div class="fw-bold text-white">Ожидает оплаты</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',5)->count() }}</div>
                            <div class="fw-bold text-white">Оплачены</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                            <!--end::Svg Icon-->
                            <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',6)->count() }}</div>
                            <div class="fw-bold text-white">Архив</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>


            </div>



            @endif

                @if (Auth::user()->type==2)
                    <div class="row g-5 g-xl-8">
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                    <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
														<rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
														<rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
														<rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
													</svg>
												</span>
                                    <!--end::Svg Icon-->
                                    <div class="text-gray-900 fw-bolder fs-5 mb-2 mt-5">{{ number_format((Auth::user()->balance), 2, ',', ' ')}} {{$adminS->currency}}</div>
                                    <div class="fw-bold text-gray-400">{{__('welcome.b')}}</div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                    <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="black"></path>
														<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="black"></path>
														<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="black"></path>
													</svg>
												</span>
                                    <!--end::Svg Icon-->
                                    <div class="text-gray-100 fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('make_id',Auth::user()->id)->count() }}</div>
                                    <div class="fw-bold text-gray-100">Всего задач</div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-warning hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
														<path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
													</svg>
												</span>
                                    <!--end::Svg Icon-->
                                    <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ \App\Models\Tasks::where('make_id',Auth::user()->id)->where('status',1)->count() }}</div>
                                    <div class="fw-bold text-white">{{__('welcome.work')}}</div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                        <div class="col-xl-3">
                            <!--begin::Statistics Widget 5-->
                            <a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                                    <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="black"></path>
														<path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="black"></path>
													</svg>
												</span>
                                    <!--end::Svg Icon-->
                                    <div class="text-white fw-bolder fs-5 mb-2 mt-5">{{ number_format((\App\Models\Tasks::where('create_id',Auth::user()->id)->where('status',5)->sum('price')), 2, ',', ' ') }} {{$adminS->currency}}</div>
                                    <div class="fw-bold text-white">{{__('welcome.sum')}}</div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                    </div>

                    <div class="card mb-5 mb-xl-8 ">
                        <div class="card-header border-0 pt-5">

                            <div class="col-md-12 hidden-xs">


                                <script src="//cdn.jsdelivr.net/npm/chart.js"></script>
                                <canvas id="myChart"></canvas>
                                <script>


                                    const labels = [
                                        @php
                                            if($request->type==1){
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".date('M Y', strtotime($date_from.' +'.$i.' month'))."'";
                                            if(strtotime($date_from.' +'.$i.' month')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                            }elseif($request->type==2){
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".date('Y', strtotime($date_from.' +'.$i.' year'))."'";
                                            if(strtotime($date_from.' +'.$i.' year')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                            }else {
                                                for ($i=0;$i<1000;$i++){
                                            echo "'".date('d.m.Y', strtotime($date_from.' +'.$i.' day'))."'";
                                            if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                            break;
                                            }else {
                                            echo ',';
                                            }
                                                 }
                                        }
                                        @endphp

                                    ];
                                    const data = {
                                        labels: labels,
                                        datasets: [ {
                                            label: '{{__('welcome.t')}}',
                                            backgroundColor: 'rgb(95, 99, 132)',
                                            borderColor: 'rgb(95, 99, 132)',
                                            data: [
                                                @php
                                                    if($request->type==1){
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id',Auth::user()->id)->where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' month')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' month'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }
                                                    }elseif($request->type==2){
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id',Auth::user()->id)->where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' year')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' year'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' year')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }
                                                    }else {
                                                    for ($i=0;$i<1000;$i++){
                                                echo "'".\App\Models\Tasks::where('make_id',Auth::user()->id)->where('make_id', '!=' , 0)->whereBetween('created_at', [date('Y-m-d', strtotime($date_from.' +'.$i.' day')), date('Y-m-d', strtotime($date_from.' +'.($i+1).' day'))])->count()."'";
                                                if(strtotime($date_from.' +'.$i.' day')>=strtotime($date_to)){
                                                break;
                                                }else {
                                                echo ',';
                                                }
                                                     }

                                                }
                                                @endphp

                                            ],
                                        }]
                                    };
                                    const config = {
                                        type: 'line',
                                        data: data,
                                        options: {
                                            legend: {
                                                labels: {
                                                    fontColor: "white"
                                                }
                                            }
                                        }
                                    };
                                    const myChart = new Chart(
                                        document.getElementById('myChart'),
                                        config
                                    );
                                </script>
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </div>


@endsection