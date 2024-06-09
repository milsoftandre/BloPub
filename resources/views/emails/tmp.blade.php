<!DOCTYPE html>
<html>
<head>
    <title>{{ $details['title'] }}</title>
</head>
<body>
<p><img src="{{ asset('assets/images/logomail.png')  }}" width="100%"></p>

<h1>{!! $details['title'] !!} </h1>
<p>{!! $details['body'] !!}</p>

<div style="
    background-color: #f2f1f1;
    width: 100%;
    height: 160px;
    text-align: center;
    padding-top: 100px;
"><h3>Сopyright 2022</h3></div>

</body>
</html>