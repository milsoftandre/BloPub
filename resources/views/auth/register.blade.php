

@extends('auth.layout')

@section('pageTitle', 'Регистрация')

@section('content')

    @php
        $settings = \App\Models\Employee::settings(1,2);
    @endphp
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">


            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">


                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <h3 class="card-header text-center">Регистрация в системе</h3>
                            <div class="card-body">
                                {{ Form::open(['route' => ['registerstore']]) }}

                                <div class="card-body py-3">
<input type="hidden" name="eid" value="{{$id}}">
                                    @foreach ($settings['form'] as $fname => $field)
                                        <div class="row mb-6 pt-2">
                                            <label class="col-lg-4 col-form-label fw-bold fs-6">
                                                <span>{{ $settings['attr'][$fname] }}</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                @if($field=='text')
                                                    {{ Form::text($fname, null, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                                @endif
                                                @if($field=='password')
                                                    {{ Form::password($fname, ['placeholder'=> $settings['attr'][$fname], 'class'=>'form-control form-control-lg form-control-solid']) }}
                                            </div>
                                        </div><div class="row mb-6">
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

                                    <button type="submit" id="kt_account_profile_details_submit" class="btn btn-primary">
                                        <span class="indicator-label"> Регистрация </span></span>
                                    </button>
                                </div>
                                {{ Form::close() }}

                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
@endsection