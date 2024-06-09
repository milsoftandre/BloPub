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
                    <div class="card-header border-0"><div class="card-title m-0"><h3 class="fw-bolder m-0">{{__('tasks.edittitle')}}</h3></div></div>
                    {{ Form::open(['route' => ['tasks.update',$model->id], 'enctype'=>'multipart/form-data']) }}

                    @method('PUT')
                    <div class="card-body py-3">

                        @foreach ($settings['form'] as $fname => $field)
                        <div class="row mb-6 pt-2 fi_{{$fname}}">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{ $settings['attr'][$fname] }}</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                @if($field=='text')

                                    @if($fname!='price')
                                        {{ Form::text($fname, $model->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                    @endif

                                    @if($fname=='price')
                                        <div class="input-group">


                                            @if($model->status>=5)
                                                {{ Form::text($fname, $model->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid priceField', 'readonly'=>'readonly']) }}
                                            @endif

                                                @if($model->status<5)
                                            {{ Form::text($fname, $model->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid priceField']) }}
                                                @endif
                                            <span class="input-group-text commissionField">0</span>
                                            <span class="input-group-text">{{$adminS->currency}}</span>
                                        </div>
                                    @endif
                                @endif
                                    @if($field=='textarea')
                                        {{ Form::textarea($fname, $model->$fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                    @endif
                                    @if($field=='date')
                                        {{ Form::date($fname, explode(" ",$model->$fname)[0], ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid', 'min'=>date("Y-m-d")]) }}
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
                                            {{ Form::select($fname, $field[0], $model->$fname,$field[1]) }}
                                        @endif
                            </div>
                        </div>
                        @endforeach
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span>Файлы</span>
                                </label>
                                <div class="col-lg-8 fv-row">
                                    <div class="file-drop-area">
                                        <span class="fake-btn">{{__('tasks.filest2')}}</span>
                                        <span class="file-msg">{{__('tasks.filest3')}}</span>
                                        <input type="file" class="file-input" name="files[]" multiple>
                                    </div>


                                    <br><br>
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
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-white btn-active-light-primary me-2"> {{__('tasks.editcs')}} </button>
                        <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                            <span class="indicator-label"> {{__('tasks.editsv')}}  </span></span>
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


    $('.delfiles').click(function(){
    var thisUrl = $(this).attr('href');
    var thisV = $(this).attr('v');
        $.get( thisUrl, function( data ) {
             $( ".del"+thisV ).remove();

        });
    return false;
    });

    if($('.make_id').val()!='0'){ $( ".fi_rek" ).hide(); }
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