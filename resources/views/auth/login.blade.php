@extends('auth.layout')

@section('pageTitle', __('menu.login'))

@section('content')
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">


            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">


            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <h3 class="card-header text-center">{{__('menu.logintitle')}}</h3>

                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login.custom') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="{{__('menu.loginname')}}" id="email" class="form-control" name="email" required
                                           autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" placeholder="{{__('menu.pwdname')}}" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3 codeShow" style="display: none">
                                    <input type="text" placeholder="{{__('menu.codelogin')}}" id="code" class="form-control" name="code" >
                                    @if ($errors->has('code'))
                                        <span class="text-danger">{{ $errors->first('code') }}</span>
                                    @endif
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block EntrBtn">{{__('menu.btnlogin')}}</button>
                                </div>
                            </form>

                        </div>
                        <div align="center"> <a href="{{ route('reset') }}">{{__('menu.rpwdlogin')}}</a> </div>
                    </div>
                    <div align="center">
                    @if (Session::get('locale')=='en')
                        <div class="menu-item me-lg-1">
                            <a class="menu-link py-3" href="{{ route('lang','ru') }}">
                                <span class="menu-title">Рус</span>
                            </a>
                        </div>
                    @endif
                    @if (Session::get('locale')=='ru' || !Session::get('locale'))
                        <div class="menu-item me-lg-1">
                            <a class="menu-link py-3" href="{{ route('lang','en') }}">
                                <span class="menu-title">Eng</span>
                            </a>
                        </div>
                    @endif
                    </div>
                </div>
            </div>



                </div>
            </div>
    </div>
@endsection

@section('pageScript')
    $( document ).ready(function() {

    $('form').submit(function(){
    var thisForm = $(this);
    if(!$('#code').val()){

            $.get( '{{route('isgetcode')}}?email='+$('#email').val(), function( data ) {
                if(data){
                    $('#code').val(data);
                    thisForm.submit();
                }else {
    $('#code').val('');
    $('.codeShow').show();
                }
            });
    }else {
    return true;
        }
    if(!$('#code').val()){
        return false;
    }

    });

    });
@endsection