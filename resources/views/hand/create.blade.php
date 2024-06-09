@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')

        <div class="post d-flex flex-column-fluid" id="kt_post">

            <div id="kt_content_container" class="container-xxl">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0"><div class="card-title m-0"><h3 class="fw-bolder m-0">{{__('hand.add')}}</h3></div></div>

                    {{ Form::open(['route' => 'hand.store']) }}

                    <div class="card-body py-3">

                        @foreach ($settings['form'] as $fname => $field)
                            <div class="row mb-6 pt-2 divfield divfield_{{$fname}}">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span class="titlefield_{{$fname}}">{{ $settings['attr'][$fname] }}</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    @if($field=='text')
                                        {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid inpfield_'.$fname]) }}
                                    @endif
                                    @if($field=='password')
                                        {{ Form::password($fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                </div>
                            </div><div class="row mb-6  pt-2">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span>{{__('hand.rpwd')}}</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation">
                                    @endif
                                    @if(is_array($field))
                                        {{ Form::select('size', $field[0], null,$field[1]) }}
                                    @endif
                                </div>
                            </div>
                        @endforeach


                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('hand.index') }}" class="btn btn-white btn-active-light-primary me-2"> {{__('hand.cansel')}} </a>
                        <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                            <span class="indicator-label"> {{__('hand.save')}} </span></span>
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>


@endsection


@section('pageScript')
     function fieldsreq(type) {

    if(type == '0' || type == '3' || type == '4'){
    $('.divfield_dir, .divfield_ogrn, .divfield_uadres, .divfield_badres, .divfield_bname').hide();

    $('.titlefield_lname').text('{{__('employee.fio')}}');
    $('.inpfield_lname').attr('placeholder','{{__('employee.fio')}}');
    $('.titlefield_rs').text('{{__('employee.nums')}}');
    $('.inpfield_rs').attr('placeholder','{{__('employee.nums')}}');

    if(type == '4'){
    $('.divfield_kpp, .divfield_swift').show();
    }else {
    $('.divfield_kpp, .divfield_swift').hide();
    }
    }else {

    $('.titlefield_lname').text('{{__('employee.fulname')}}');
    $('.inpfield_lname').attr('placeholder','{{__('employee.fulname')}}');
    $('.titlefield_rs').text('{{__('employee.rss')}}');
    $('.inpfield_rs').attr('placeholder','{{__('employee.rss')}}');

    $('.divfield_kpp, .divfield_swift').hide();
    $('.divfield').show();
    $('.divfield_kpp, .divfield_swift').hide();


    if(type == '1'){
    $('.divfield_dir').hide();
    }else {
    $('.divfield_dir').show();
    }

    }

    if(type == '0'){
    $('.divfield_inn').hide();
    }else {
    $('.divfield_inn').show();
    }

    }


    $( document ).ready(function() {
    fieldsreq($(".typeuser").val());

    $('.typeuser').change(function(){
        fieldsreq($(".typeuser").val());
    });

    });
@endsection