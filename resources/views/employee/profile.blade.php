@extends('base.base')

@section('pageTitle', __('menu.profile'))

@section('content')

    {{ Form::open(['route' => ['employee.update',$model->id], 'enctype'=>'multipart/form-data']) }}
<div class="row">

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{($model->file)?asset('upload/images/'.$model->file):'assets/images/avatars/avatar-2.png'}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110" id="avaimg" style="min-width: 110px;min-height: 110px;">
                    <input type="file" name="file" id="file" style="display: none">

                    <div class="mt-3">
                        <h4>{{$model->name}}</h4>
                        <p class="mb-1">{{$model->email}}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-8">
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
                    <div class="card-header border-0"><div class="card-title m-0"><h3 class="fw-bolder m-0">{{__('menu.profile')}}</h3></div></div>


                    @method('PUT')
                    <div class="card-body py-3">
                        <input type="hidden" class="form-control form-control-lg form-control-solid" name="profile" value="1">
                        @foreach ($settings['form'] as $fname => $field)

                            @if($field=='password')
                                <div class="row mb-6 pt-2 divfield divfield_{{$fname}}">
                                    <h3>{{__('employee.pwd')}}</h3>
                                </div>
                            @endif
                        <div class="row mb-6 pt-2 divfield divfield_{{$fname}}">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span class="titlefield_{{$fname}}">{{ $settings['attr'][$fname] }}</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                @if($field=='text')
                                    @php
                                    $arr = ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid inpfield_'.$fname];
                                    if($fname=='email' || $fname=='tel'){
                                    $arr['readonly'] = 'readonly';
                                    $arr['class'] = 'form-control form-control-lg form-control-solid readonlyIMP inpfield_'.$fname;
                                    }
                                    if($fname=='email'){
                                    $arr['id'] = 'email';
                                    }

                                    @endphp


                                        {{ Form::text($fname, $model->$fname, $arr) }}

                                    @if($fname=='tel')
                                        <button type="button" id="kt_account_profile_details_submit" class="btn btn-sm btn-success sendcodep">
                                            <span class="indicator-label"> Отправить код на email для редактирования </span></span>
                                        </button>
                                        {{ Form::text('code', null, ['placeholder'=> 'Код отправленный на email', 'class'=>'form-control form-control-lg form-control-solid sendcodepinp', 'style'=>'display:none']) }}
                                    @endif
                                @endif
                                    @if($field=='password')

                                        {{ Form::password($fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                            </div>
                        </div><div class="row mb-6 pt-2">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{__('employee.rpwd')}}</span>
                            </label>
                                            <div class="col-lg-8 fv-row">
                                            <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation">
                                    @endif
                                        @if(is_array($field))
                                            {{ Form::select($fname, $field[0], $model->$fname,$field[1]) }}
                                        @endif
                            </div>
                        </div>
                        @endforeach


                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                            <span class="indicator-label"> {{__('employee.edit_save')}} </span></span>
                        </button>
                    </div>
                    <div class="card-body py-3">
                    <h3>API Token</h3>
                    @if(empty($model->token))
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" id="kt_account_profile_details_submit" name="api" value="1" class="btn btn-primary">
                            <span class="indicator-label"> Создать ключ </span></span>
                        </button>
                    </div>

                    @endif

                    @if($model->token)
                    <code>{{$model->token}}</code>
                            <div class="row mb-6 pt-2">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span class="titlefield_apiips">{{ $settings['attr']['apiips'] }}</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    {{ Form::textarea('apiips', $model->apiips, ['placeholder'=> $settings['attr']['apiips'], 'class'=>'form-control form-control-lg form-control-solid inpfield_apiips']) }}
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="submit" id="kt_account_profile_details_submit" name="delapi" value="1" class="btn btn-warning">
                                    <span class="indicator-label"> {{__('employee.bdel')}} API Token</span></span>
                                </button> &nbsp;
                                <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                                    <span class="indicator-label"> {{__('employee.edit_save')}} </span></span>
                                </button>
                            </div>
                    @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
{{ Form::close() }}
@endsection

@section('pageScript')

    $( document ).ready(function() {

    $('.sendcodep').click(function(){
    $.get( '{{route('isgetcode')}}?email='+$('#email').val(), function( data ) {
        $('.sendcodep').hide();
        $('.sendcodepinp').show();
    $('.readonlyIMP').removeAttr( "readonly" );
    });

    return false;


    });

    });



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
    $(".divfield_typeuser").hide();
    fieldsreq($(".typeuser").val());

    $('.typeuser').change(function(){
    fieldsreq($(".typeuser").val());
    });

    $('#avaimg').click(function(){
    $('#file').trigger('click');
    return false;
    });

    var _URL = window.URL || window.webkitURL;

    $("#file").change(function(e) {
    var file, img;


    if ((file = this.files[0])) {
    img = new Image();

    img.onload = function() {
//    alert(this.width + " " + this.height);
        if(this.width>600 && this.height>600){
            document.getElementById("file").value = "";
    document.getElementById("avaimg").src = 'assets/images/avatars/avatar-2.png';
    Lobibox.notify('info', {
    pauseDelayOnHover: true,
    continueDelayOnInactiveTab: false,
    position: 'top right',
    icon: 'bx bx-info-circle',
    msg: "Файл не может быть больше 600pxх600px"
    });
        }else {
        }
    };
    img.onerror = function() {
    Lobibox.notify('info', {
    pauseDelayOnHover: true,
    continueDelayOnInactiveTab: false,
    position: 'top right',
    icon: 'bx bx-info-circle',
    msg: "Ошибка"
    });
    };
    img.src = _URL.createObjectURL(file);


    }
    return false;
    });


    });


    document.getElementById('file').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
    files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
    var fr = new FileReader();
    fr.onload = function () {
    if(document.getElementById("file").value != ""){
    document.getElementById("avaimg").src = fr.result;
    }
    }
    fr.readAsDataURL(files[0]);
    }

    // Not supported
    else {
    // fallback -- perhaps submit the input to an iframe and temporarily store
    // them on the server until the user's session ends.
    }
    }


@endsection

