@extends('auth.layout')

@section('pageTitle', 'Забыли пароль?')

@section('content')
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14.png">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">


            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">


            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <h3 class="card-header text-center">Забыли пароль?</h3>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    {{ $message }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('login.reset') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email (логин)" id="email" class="form-control" name="email" required
                                           autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>


                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block EntrBtn">Отправить новый</button>
                                </div>
                            </form>

                        </div>
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
    return true;
            $('.codeShow').show();
            $('#code').focus();
            $.get( '{{route('getcode')}}?email='+$('#email').val(), function( data ) {


            });
    if(!$('#code').val()){
        return false;
    }
    });

    });
@endsection