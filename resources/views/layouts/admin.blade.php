<!doctype html>
<html lang="en" ng-app="PYSCore" ng-controller="MainController">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="fragment" content="!" />
<title>@{{ $root.title }} - PYSCore</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui/0.4.0/angular-ui.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.0.1/sweetalert.min.css"/>
<link rel="stylesheet" href="{{ url('css/main.css') }}"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.3/angular-sanitize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.3/angular-route.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.3/angular-messages.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.2.15/angular-locale_vi-vn.js"></script>
<script>
var app = angular.module('PYSCore', ['ngRoute', 'ngSanitize', 'ngMessages']).constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
</script>
<script src="{{ url('js/PYSCore.js') }}"></script>
<script src="{{ url('js/TourController.js') }}"></script>
<script src="{{ url('js/BookingController.js') }}"></script>
<script src="{{ url('js/UserController.js') }}"></script>
</head>
<body ng-app="PYSCore" ng-controller="MainController">
<header id="header" class="container-fluid">
    <div class="left">

    </div>
    <div class="right">
        <div class="currentUser">
            Xin Chào! {{ Auth::user()->name }}
            <ul class="submenu">
                <li><a href="" onclick="logOut()">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</header>

<div class="container-fluid" id="MainContent">
    <div class="row">
        <aside id="sidebar" class="col-xs-2">
            <ul>
                @if(canModifyTour())
                    <li><a href="{{ url('tour') }}">Tour</a></li>
                @endif
                @if(canModifyBooking())
                    <li><a href="{{ url('booking') }}">Booking</a></li>
                @endif
                @if(canModifyUser())
                    <li><a href="{{ url('user') }}">Người dùng</a></li>
                @endif
            </ul>
        </aside>

        <main id="main" class="col-xs-10">
            <div ng-view></div>
        </main>
    </div>
</div>

<div id="footer">

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.1/jquery.sticky.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui/0.4.0/angular-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.0.1/sweetalert.min.js"></script>
</body>
</html>