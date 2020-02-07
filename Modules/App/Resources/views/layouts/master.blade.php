<!doctype html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
<body>
  <noscript>
    <strong>Без включенного JavaScript работа не возможна.</strong>
  </noscript>
  <div id="admin">
    @yield('content')
  </div>
  <script src="{{mix('/js/app.js')}}" type="application/javascript"></script>
@yield('view.scripts')
</body>
</html>