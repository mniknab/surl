<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
        }
        .message {
            font-size: 18px;
            text-align: center;
        }
        .footer {
            position: absolute;
            bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #636b6f;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="code">
        @yield('code')
    </div>

    <div class="message" style="padding: 10px;">
        @yield('message')
    </div>

    <div class="footer">
        SURL - <small> By <a href="https://github.com/mniknab" title="By Mohammad Niknab" target="_blank">Mohammad Niknab</a> </small>
    </div>
</div>
</body>
</html>
