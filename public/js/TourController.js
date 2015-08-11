app.controller('TourController', function ($scope, $http, $rootScope) {
    $http.get("/tour/indexApi")
        .success(function (response) {
            $scope.data = response;
        }
    );
    $scope.add = true;
    $scope.addTour = (function(){
        $(".tourForm").addClass('display');
        $scope.add = true;
    });
    $scope.cancel = (function(){
        $(".popUp").removeClass('display');
    });
    $scope.postNew = (function(){
        $http.post('/tour', $scope.cur).success(function (data) {
            $scope.data.push(data);
            swal("Thêm thành công tour mới", '', 'success');
        }).error(function (data) {
            swal({
                title: "<b>Không thể thêm tour mới</b>",
                text: $rootScope.arrayToList(data),
                html: true,
                type: 'error'
            })
        });
        $(".popUp").removeClass('display');
    });
    $scope.delete = (function(x){
        if(confirm("Bạn có muốn xóa tour này?")) {
            $http.delete('/tour/' + x.id)
                .success(function (data) {
                    $scope.data.splice($scope.data.indexOf(x), 1);
                    swal("Xóa thành công", '', 'success');
                })
                .error(function (data) {
                    swal({
                        title: "<b>Có lỗi xảy ra, không thể xóa tour này</b>",
                        text: $rootScope.arrayToList(data),
                        html: true,
                        type: 'error'
                    });
                });
        }
    });
    $scope.edit = (function (x) {
        jQuery(".tourForm").addClass('display');
        $scope.add = false;
        $scope.cur = x;
    });

    $scope.update = (function () {
        $http.put('/tour/' + $scope.cur.id, $scope.cur)
            .success(function (data){
                for(var i = 0; i < $scope.data.length; i++ ){
                    if($scope.data[i].id == $scope.id) {
                        $scope.data[i] = $scope.cur;
                    }
                }
                jQuery(".popUp").removeClass('display');
                swal("Cập nhật thành công tour " + data.tentour, '', 'success');
            })
            .error(function (data) {
                swal({
                    title: "<b>Lỗi! Không thể cập nhật</b>",
                    text: $rootScope.arrayToList(data),
                    html: true,
                    type: 'error'
                });
            })
    });
    
    $scope.search = (function () {
        $http.post('/tour/search', $scope.find)
            .success(function (data) {
                $scope.data = data;
            })
            .error(function (data) {
                swal("Lỗi kết nối", "", "error");
            });
    });
});

