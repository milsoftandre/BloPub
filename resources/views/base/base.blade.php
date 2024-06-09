<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->

    <link href="{{ asset('assets/plugins/notifications/css/lobibox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    @yield("style")
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script>
        paceOptions = {
            ajax: false, // disabled
            document: true, // enabled
            eventLag: false, // disabled

        };
    </script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <style>

        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        .modal-backdrop.show {
            opacity: 0;
        }
        input[type='date'], input[type='time'] {
            -webkit-appearance: none;
            height: 38px;
        }
        @media screen and (max-width: 600px) {
            .hidden-xs {
                display: none;
            }
        }
    </style>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/notifications/js/lobibox.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <title>@yield('pageTitle')</title>
</head>

<body class="bg-theme bg-theme2">
<!--wrapper-->
<div class="wrapper">
    <!--start header -->
@include("base.headermenu")
<!--end header -->
    <!--navigation-->
@include("base.menu")
<!--end navigation-->
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
    @yield('content')
        </div></div>


    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    @include('base.footer')

</div>
@include('base.modals')


@yield("script")

<script>
    @yield('pageScript')

    $( document ).ready(function() {
        $('.form-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        $(".page-wrapper").css("min-height", ($( document ).height()- 157)+"px");

        $('.text-end form').submit(function(){
            var thisUrl = $(this).attr('action');
            var thisForm = $(this);
            $('#delmodal').modal('show');

            $('.btndel').click(function(){
                var thisV = $(this).attr('v');
                if(thisV == '1'){
                $.ajax(
                    {
                        url: thisUrl,
                        type: 'delete', // replaced from put
                        dataType: "POST",
                        data: thisForm.serialize(),
                        success: function (response)
                        {
                            thisForm.parent( ".text-end" ).parent( "tr" ).remove();
                            console.log(response); // see the reponse sent
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // this line will save you tons of hours while debugging
                            // do something here because of error

                            thisForm.parent( ".text-end" ).parent( "tr" ).remove();
                            $('#delmodal').modal('hide');
                        }
                    });
                }else {
                    thisUrl = '';
                    thisForm = '';
                }

            });

            return false;
        });

        $('.alert').attr('class','').attr('class','alert border-0 alert-dismissible fade show');
    });

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        Lobibox.notify('info', {
            pauseDelayOnHover: true,
            continueDelayOnInactiveTab: false,
            position: 'top right',
            icon: 'bx bx-info-circle',
            msg: "Ссылка скопирована"
        });

    }
</script>


</body>

</html>

@if (Auth::user()->type!=0)
<div style="position: fixed; bottom: 50px; right: 50px;z-index: 999;">
    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="modal" data-bs-target="#exampleLargeModal2" onclick="upChatRead();" style="font-size: 34px;">

        <i class='bx bxs-bell bx-tada bx-md'></i>
    </a>
</div>
@endif
<div class="modal fade" id="exampleLargeModal2" tabindex="-1" aria-hidden="true" style="opacity: 0.97; ">
    <div class="modal-dialog modal-lg" style="position: absolute;right: 25px;bottom: 0px;">
        <div class="modal-content" style="border-radius: 0.5rem;-webkit-box-shadow: 5px 5px 12px 5px rgba(0,0,0,0.57); box-shadow: 5px 5px 12px 5px rgba(0,0,0,0.57);">
            <div class="modal-header" style="padding: 5px;">
                <h5 class="modal-title">&nbsp;{{__('chat.tp')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: -20px; left: -30px;"></button>
            </div>
            <div class="modal-body" style="padding: 0px;">
                {{view('chatall')}}
            </div>
        </div>
    </div>
</div>
