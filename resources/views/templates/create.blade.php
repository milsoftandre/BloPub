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
                    <div class="card-header border-0"><div class="card-title m-0"><h3 class="fw-bolder m-0">{{__('templates.add')}}</h3></div></div>

                        {{ Form::open(['route' => 'templates.store']) }}

                    <div class="card-body py-3">

                        @foreach ($settings['form'] as $fname => $field)
                        <div class="row mb-6 pt-2">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{ $settings['attr'][$fname] }}</span>
                            </label>
                            <div class="col-lg-8 fv-row">
                                @if($field=='textarea')
                                    {{ Form::textarea($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                @endif
                                @if($field=='text')
                                        {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                @endif
                                    @if($field=='password')
                                        {{ Form::password($fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                            </div>
                        </div><div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                <span>{{__('templates.rpwd')}}</span>
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
                        <button type="reset" class="btn btn-white btn-active-light-primary me-2"> {{__('templates.cansel')}} </button>
                        <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                            <span class="indicator-label"> {{__('templates.save')}} </span></span>
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
        <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'text' );
        </script>

@endsection