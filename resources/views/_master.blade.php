<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Surl Management">
        <meta name="author" content="MohammadNiknab">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Google Font CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

        <style>
            *{
                font-family: Nunito,sans-serif;
            }
        </style>

        @yield('styles')

        <title>Surl Management</title>
    </head>
    <body>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 my-5">
                    <h1 class="text-center">Surl Management</h1>
                    <div class="text-center">
                        <small> By <a class="text-muted" href="https://github.com/mniknab" title="By Mohammad Niknab" target="_blank">Mohammad Niknab</a> </small>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                @yield('content')
            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        @yield('scripts')
    </body>
</html>
