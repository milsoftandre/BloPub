<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('pageTitle')</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />

    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ asset("assets/media/logos/favicon.ico") }}" />

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset("assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset("assets/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />

</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
<div class="d-flex flex-column flex-root">

        <div class="d-flex flex-column flex-row-fluid" id="kt_wrapper" style="padding: 50px;">


            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                <div id="kt_post">

                    {{ Form::open(['route' => ['docs.create'],'method' => 'get']) }}
                    <div class="row">
                    <div class="col-6 pt-2">
                    {{ Form::text('name', '', ['placeholder'=> 'Название (исполнитель)', 'class'=>'form-control']) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::text('name2', '', ['placeholder'=> 'Название (заказчик)', 'class'=>'form-control']) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::textarea('rek', '', ['placeholder'=> 'Реквизиты (исполнитель)', 'class'=>'form-control', 'rows'=>3]) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::textarea('rek2', '', ['placeholder'=> 'Реквизиты (заказчик)', 'class'=>'form-control', 'rows'=>3]) }}
                    </div><div class="col-12 pt-2">
                    {{ Form::textarea('text', '', ['placeholder'=> 'Основание', 'class'=>'form-control', 'rows'=>3]) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::text('num', '', ['placeholder'=> 'Номер акта', 'class'=>'form-control']) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::date('date', '', ['placeholder'=> 'Дата', 'class'=>'form-control']) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::text('service', '', ['placeholder'=> 'Услуги', 'class'=>'form-control']) }}
                    </div><div class="col-6 pt-2">
                    {{ Form::text('sum', '', ['placeholder'=> 'Стоимость', 'class'=>'form-control']) }}
                    </div><div class="col-12 pt-2" align="center">

                    <button type="submit" class="btn btn-primary ">
                        <span class="indicator-label"> Скачать </span></span>
                    </button>
                    </div>
                    </div>

                    {{ Form::close() }}

                </div>

            </div>


        </div>
    </div>

</div>



<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="fas fa-arrow-up"></i>
</div>


<script>var hostUrl = "assets/";</script>

<script src="{{ asset("assets/plugins/global/plugins.bundle.js") }}"></script>
<script src="{{ asset("assets/js/scripts.bundle.js") }}"></script>

<script src="{{ asset("assets/js/custom/widgets.js") }}"></script>
<script src="{{ asset("assets/js/custom/apps/chat/chat.js") }}"></script>
<script src="{{ asset("assets/js/custom/modals/create-app.js") }}"></script>
<script src="{{ asset("assets/js/custom/modals/upgrade-plan.js") }}"></script>


</body>

</html>




