@extends('base.base')

@section('pageTitle', $settings['title'])

@section('content')

    @php $adminS = \App\Models\Settings::find(1); @endphp

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
                    <div class="card-header border-0"><div class="card-title m-0"><h3 class="fw-bolder m-0">{{__('tasks.create')}}</h3></div></div>

                        {{ Form::open(['route' => 'tasks.store', 'enctype'=>'multipart/form-data']) }}

                    <div class="card-body py-3">

                        @foreach ($settings['form'] as $fname => $field)
                        <div class="row mb-6 pt-2 fi_{{$fname}}">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{ $settings['attr'][$fname] }}</span>
                            </label>
                            <div class="col-lg-8 fv-row cyclecl" {!! (($fname=='cycle')?'style="display:none"':'') !!}>
                                @if($field=='text')
                                    @if($fname!='price'&&$fname!='cycle')
                                        {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                    @endif
                                        @if($fname=='cycle')
                                            <div class="input-group">
                                                {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid inputcicle']) }}
                                                <span class="input-group-text ">{{$settings['attr']['date_cycle']}} &nbsp;
                                                    <input type="checkbox" name="shov" value="" onclick=" if($(this).prop('checked')){ $('.inputcicle2').show(); $('.inputcicle').hide(); }else { $('.inputcicle').show(); $('.inputcicle2').hide(); } ">
                                                </span>
                                                {{ Form::date('date_cycle', null, ['placeholder'=> $settings['attr']['date_cycle'], 'class'=>'form-control form-control-lg form-control-solid inputcicle2', 'style'=>'display:none', 'min'=>date("Y-m-d")]) }}

                                            </div>

                                        @endif

                                        @if($fname=='price')
                                    <div class="input-group">
                                        {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid priceField']) }}
                                        <span class="input-group-text commissionField">0</span>
                                        <span class="input-group-text">{{$adminS->currency}}</span>
                                    </div>
                                        @endif
                                @endif


                                    @if($field=='textarea')
                                        {{ Form::textarea($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                    @endif
                                    @if($field=='date')
                                        {{ Form::date($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid', 'min'=>date("Y-m-d")]) }}
                                    @endif
                                    @if($field=='password')
                                        {{ Form::password($fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                            </div>
                        </div><div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>Повторите пароль</span>
                            </label>
                                            <div class="col-lg-8 fv-row">
                                            <input type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation">
                                    @endif
                                        @if(is_array($field))
                                            {{ Form::select($fname, $field[0], null,$field[1]) }}
                                        @endif

                                                @if($fname!='price')

                                                @endif

                            </div>
                                @if($fname=='cycle')
                                <div class="col-lg-8 fv-row cyclecl2">
                                    <input type="checkbox" name="shov" value="" onclick="$('.cyclecl').show(); $('.cyclecl2').hide();">
                                </div>
                                @endif

                        </div>
                        @endforeach

                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span>{{__('tasks.filest')}}</span>
                                </label>
                                <div class="col-lg-8 fv-row">

                                    <div class="file-drop-area">
                                        <span class="fake-btn">{{__('tasks.filest2')}}</span>
                                        <span class="file-msg">{{__('tasks.filest3')}}</span>
                                        <input type="file" class="file-input" name="files[]" multiple>
                                    </div>

                                </div>
                            </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-white btn-active-light-primary me-2"> {{__('tasks.cs')}} </button>
                        <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                            <span class="indicator-label"> {{__('tasks.sv')}} </span></span>
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>

<style>
    .file-drop-area {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 100%;
        padding: 25px;
        border: 1px dashed rgba(255, 255, 255, 0.4);
        border-radius: 3px;
        transition: 0.2s;
    &.is-active {
         background-color: rgba(255, 255, 255, 0.05);
     }
    }

    .fake-btn {
        flex-shrink: 0;
        background-color: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .file-msg {
        font-size: small;
        font-weight: 300;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;
    &:focus {
         outline: none;
     }
    }


    }
</style>
@endsection

@section('pageScript')
    $( document ).ready(function() {




    $('.make_id').change(function(){
    var thisV = $(this).val();
    if(thisV=='0'){
        $( ".fi_rek" ).show();
    }else {
        $( ".fi_rek" ).hide();
    }
    });


    $( ".priceField, .make_id" ).on( "change keyup", function() {

        if($('.make_id').val()=='0'){
            $('.commissionField').text((($('.priceField').val()*({{$adminS->commissionnone}}/100))+ + $('.priceField').val()).toFixed(2));
        }else {
            $('.commissionField').text(($('.priceField').val()*({{$adminS->commission}}/100)+ + $('.priceField').val()).toFixed(2));
        }

    });

    $('.priceField').trigger('change');


    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
    $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
    $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
    var filesCount = $(this)[0].files.length;
    var $textContainer = $(this).prev();

    if (filesCount === 1) {
    // if single file is selected, show file name
    var fileName = $(this).val().split('\\').pop();
    $textContainer.text(fileName);
    } else {
    // otherwise show number of files
    $textContainer.text(filesCount + ' files selected');
    }
    });

    });
@endsection