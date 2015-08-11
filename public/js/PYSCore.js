app.filter('unsafe', function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    }
});

app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            title: 'Trang chủ',
            controller: 'MainController'
        })
        .when('/tour', {
            templateUrl: '/tour/tourTemplate',
            controller: 'TourController',
            controllerAs: 'tour',
            title: 'Quản lý tour'
        })
        .when('/booking/tour/:tourId', {
            templateUrl: '/booking/bookingTemplate',
            controller: 'BookingController',
            title: 'Quản lý tour'
        })
        .when('/booking', {
            templateUrl: '/booking/bookingTemplate',
            controller: 'BookingController',
            controllerAs: 'booking',
            title: 'Quản lý booking'
        })
        .when('/user', {
            templateUrl: '/user/getIndexTemplate',
            controller: 'UserController',
            controllerAs: 'user',
            title: 'Quản lý người dùng'
        })
        .otherwise({
            redirectTo: '/'
        });
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
}]);

app.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        if(current.hasOwnProperty('$$route')) {
            $rootScope.title = current.$$route.title;
        }
    });
    $rootScope.arrayToList = (function (data) {
        var str = '';
        if(data.isArray) {
            str += '<ul>';
                for(var i = 0; i < data.length; i++) {
                    if(data[i].isArray) {
                        str += $rootScope.arrayToList(data[i]);
                    }
                    else {
                        str += '<li>' + data[i] + '</li>';
                    }
                }
            str += '</ul>';
            return str;
        } else {
            return data;
        }
    });
}]);

app.controller('MainController', ['$route', '$routeParams', '$location', '$scope', function($route, $routeParams, $location, $scope){
    $scope.$route = $route;
    $scope.$routeParams = $routeParams;
    $scope.$location = $location;
    $scope.title = "PYS Core";
}]);

jQuery(document).ready(function ($) {
    $("#sidebar > ul").sticky({
        topSpacing: 25
    });
});


var logOut = (function () {
    window.location = '/auth/logout';
});