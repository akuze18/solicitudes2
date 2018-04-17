<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('/nh_food_mini.ico')}}">

    <title>Intranet de {{env('COMP_LONG')}}</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ url('/css/accordion-menu_3.css')}}"><!---->
    <link rel="stylesheet" href="{{ url('/css/navbar-fixed-top2.css')}}">
    <link rel="stylesheet" href="{{ url('/css/bootstrap-mod.css?v='.date('mdYhis'))}}">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{env('COMP_SHORT')}} </a>
        </div>
        @if (Auth::guest())
            @include('layouts.menu.guest')
        @else
            @include('layouts.menu.logon')
        @endif
    </div>

</nav>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron row">
        @if(Auth::guest())
            <div class="col-md-12">
                @yield('content')
            </div>
        @else
            <div class="col-md-3">
                @include('layouts.panel2')
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        @endif
    </div>
</div> <!-- /container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
<script src="{{url('/js/bootstrap.min.js')}}"></script>
@yield('extra_js')
</body>
</html>



