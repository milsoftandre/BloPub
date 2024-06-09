@extends('base.base')

@section('pageTitle', 'API')

@section('content')

        <div class="post d-flex flex-column-fluid" id="kt_post">

            <div id="kt_content_container" class="container-xxl">
                API интерфейс использует Token Authentication для авторизации.<br>
                Token – используйте тот же что и у сотрудника.<br>
                Все ответы в JSON формате, результаты доступны аналогично прав пользователя внутри системы.
                <br><br>
                Ошибка авторизации:<br>
                <pre>{
    "name":"Unauthorized",
    "message":"Your request was made with invalid credentials.",
    "code":0,
    "status":401,
}        </pre> <br>
                status = 200 – успешная авторизация        <br>

                http://104.248.167.68/work/1blo/api<br>

                Доступные Методы:<br>
                <h3>http://104.248.167.68/work/1blo/api/register - Регистрация POST </h3><br>
                Поля:
                <div class="row mb-6 pt-2">

                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>TOKEN</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        token
                    </div>
                </div>
                @foreach ($settings['form'] as $fname => $field)
                    <div class="row mb-6 pt-2">

                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ $settings['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach
                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/finance?token=YOUR_TOKEN - GET Финансы </h3>

                @foreach (\App\Models\Finance::settings()['attr'] as $fname => $field)
                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ \App\Models\Finance::settings()['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach

                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/tasks?token=YOUR_TOKEN - Задачи GET</h3>

                @foreach (\App\Models\Tasks::settings()['attr'] as $fname => $field)
                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ \App\Models\Tasks::settings()['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach

                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/addtasks?token=YOUR_TOKEN - Добавить Задачу POST</h3>

                @foreach (\App\Models\Tasks::settings()['attr'] as $fname => $field)
                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ \App\Models\Tasks::settings()['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach
                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/edittasks?token=YOUR_TOKEN - Редактировать Задачу POST</h3>
                <div class="row mb-6 pt-2">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span>ID</span>
                    </label>
                    <div class="col-lg-8 fv-row">
                        ID
                    </div>
                </div>
                @foreach (\App\Models\Tasks::settings()['attr'] as $fname => $field)
                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ \App\Models\Tasks::settings()['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach
                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/tasksdestroy?token=YOUR_TOKEN - Удалить задачу GET</h3>


                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>ID</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                           ID задачи
                        </div>
                    </div>


                <br><br>
                <h3>http://104.248.167.68/work/1blo/api/withdrawal?token=YOUR_TOKEN - Вывод средств
                </h3>

                @foreach (\App\Models\Withdrawal::settings()['attr'] as $fname => $field)
                    <div class="row mb-6 pt-2">
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span>{{ \App\Models\Withdrawal::settings()['attr'][$fname] }}</span>
                        </label>
                        <div class="col-lg-8 fv-row">
                            {{$fname}}
                        </div>
                    </div>
                @endforeach


            </div>
        </div>


@endsection