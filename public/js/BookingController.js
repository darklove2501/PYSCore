app.controller('BookingController', function ($scope, $http, $routeParams, $rootScope) {
    $scope.$routeParams = $routeParams;

    //Sort default
    $scope.sortType = 'id';
    $scope.sortReverse = true;

    if($scope.$routeParams.tourId) {
        $http.post("/booking/getByTour", $scope.$routeParams)
            .success(function (data) {
                $scope.data = data;
            })
            .error(function (data) {
                swal({
                    title: "Không thể lấy dữ liệu từ tour này. Vui lòng liên hệ với quản trị viên",
                    text: '',
                    type: 'error'
                })
            })
    } else {
        $http.get("/booking/indexApi")
            .success(function (response) {
                $scope.data = response;
            }
        );
    }
    $http.get("/tour/indexApi")
        .success(function (data) {
            $scope.tour = data;
        });

    $scope.totalPrice = (function (x) {
        return x.tour.giatreem * x.sotreem + x.tour.gianguoilon * x.songuoilon;
    });

    $scope.add = true;
    $scope.addBooking = (function () {
        $(".bookingForm").addClass('display');
        $scope.add = true;
    });
    $scope.cancel = (function () {
        $(".popUp").removeClass('display');
    });
    $scope.postNew = (function () {
        $http.post('/booking', $scope.cur).success(function (data) {
            data.ngaydi = data.ngaydi.substring(0, 10);
            $scope.data.push(data);
            swal("Thêm thành công tour mới", "", "success");
        }).error(function (data) {
            swal({
                title: "<b>Lỗi! Không thể thêm booking mới</b>",
                text: $rootScope.arrayToList(data),
                html: true,
                type: "error"
            })
        });
        $(".popUp").removeClass('display');
    });
    $scope.delete = (function (x) {
        if (confirm("Bạn có muốn xóa tour này?")) {
            $http.delete('/booking/' + x.id)
                .success(function () {
                    $scope.data.splice($scope.data.indexOf(x), 1);
                    swal("Xóa thành công", "", "success");
                })
                .error(function (data) {
                    swal({
                        title: "<b>Có lỗi xảy ra, không thể xóa tour này</b>",
                        text: $rootScope.arrayToList(data),
                        html: true,
                        type: "error"
                    })
                });
        }
    });
    $scope.edit = (function (x) {
        jQuery(".bookingForm").addClass('display');
        $scope.add = false;
        $scope.cur = x;
    });
    $scope.update = (function () {
        $http.put('/booking/' + $scope.cur.id, $scope.cur)
            .success(function (data) {
                swal("Cập nhật thành công booking của " + data.hoten, "", "success");
                for (var i = 0; i < $scope.data.length; i++) {
                    if ($scope.data[i].id == $scope.id) {
                        $scope.data[i] = data;
                        break;
                    }
                }
                jQuery(".popUp").removeClass('display');
            })
            .error(function (data) {
                jQuery(".popUp").removeClass('display');
                swal({
                    title: "<b>Lỗi! Không thể cập nhật</b>",
                    text: $rootScope.arrayToList(data),
                    html: true,
                    type: "error"
                })
            })
    });
    $scope.chitiet = (function (x) {
        $scope.cur = x;
        jQuery(".chiTietBooking").addClass('display');
    });
    $scope.searchBooking = (function () {
        $http.post('/booking/searchApi', {
            "searchString": $scope.searchString
        })
            .success(function (data) {
                $scope.data = data;
            })
            .error(function () {
                swal("Lỗi! Không tìm kiếm được.", "", "error");
            });
    });
});