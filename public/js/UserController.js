app.controller("UserController", function($http, $scope, $rootScope){

    //Get all user data
    $http.get('/user/getAllUser')
        .success(function (data) {
            $scope.data = data;
        });

    $http.get('/role/getAll')
        .success(function (data) {
            $scope.role = data;
            $scope.roleId = [];
        });

    //Open add new user modal
    $scope.addUser = (function () {
        jQuery(".addUserForm").addClass('display');
    });

    //Execute add new user progress
    $scope.newUser = {
        name: '',
        email: '',
        password: '',
        repassword: ''
    };
    $scope.postNew = (function () {
        $http.post('/user/postNew', $scope.newUser)
            .success(function (data) {
                $scope.data.push(data);
                $scope.errorMsg = null;
                swal("Thêm thành công " + $scope.newUser.name, '', 'success');
                $scope.cancel();
            })
            .error(function (data) {
                $scope.successMsg = null;
                swal({
                    title: "Lỗi! Không thể thêm " + $scope.newUser.name,
                    text: $rootScope.arrayToList(data),
                    html: true,
                    type: 'error'
                });
            });
    });

    //Pop up edit user modal
    $scope.edit = (function (x) {
        $scope.editUser = x;
        jQuery(".editUserForm").addClass('display');
    });

    //Execute update user progress
    $scope.updateUser = (function () {
        $http.put('/user/update/' + $scope.editUser.id, $scope.editUser)
            .success(function (data) {
                swal("Cập nhật thành công người dùng " + $scope.editUser.name, '', 'success');
                jQuery.each(data, function (k, v) {
                    if($scope.data[k].id == data.id) {
                        $scope.data[k] = data;
                    }
                });
            })
            .error(function (data) {
                swal({
                    title: "Lỗi, không thể cập nhật thông tin",
                    text: $rootScope.arrayToList(data),
                    html: true,
                    type: 'error'
                });
            });
    });

    //Pop edit password form
    $scope.editPassword = (function (x) {
        $scope.editUser = x;
        jQuery(".editPasswordForm").addClass('display');
    });

    //Execute the update password form
    $scope.updateUserPassword = (function () {
        $http.put('/user/updatePassword/' + $scope.editUser.id, $scope.editUser)
            .success(function (data) {
                swal("Cập nhật mật khẩu thành công cho " + $scope.editUser.name, '', 'success');
                $scope.cancel();
            })
            .error(function (data) {
                swal({
                    title: "Không thể cập nhật mật khẩu",
                    text: $rootScope.arrayToList(data),
                    type: 'error',
                    html: true
                });
            });
    });

    //Delete User
    $scope.delete = (function (x) {
        swal({
            title: "Bạn có chắc chắn muốn xóa người dùng này?",
            text: "Khi thực hiện việc xóa người dùng này, bạn sẽ không thể phục hồi lại được!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Vâng, xóa người dùng này!",
            cancelButtonText: "Không, đừng xóa!",
            closeOnConfirm: false
        }, function () {
                $http.post('/user/delete/' + x.id, {})
                    .success(function (data) {
                        swal("Thành công", "Bạn đã xóa thành công " + x.name, "success");
                        $scope.data.splice($scope.data.indexOf(x), 1);
                    })
                    .error(function (data) {
                        swal("Không thể xóa người dùng này", 'Có lỗi xảy ra. Vui lòng liên hệ với quản trị viên để khắc phục', "error");
                    });
            }
        );
    });

    //Pop the permission form
    $scope.editRole = (function (x) {
        $scope.roleId = [];
        $http.get('/user/role/' + x.id)
            .success(function (data) {
                $scope.curUser = x;
                $scope.curRole = data;
                $scope.editUser = x;
                angular.forEach($scope.role, function (v, k) {
                    $scope.roleId[k] = false;
                });
                $scope.roleId[$scope.role.length] = false;
                angular.forEach(data, function (v, k) {
                    $scope.roleId[v.id] = true;
                });
                jQuery(".editRoleForm").addClass('display');
            })
            .error(function (data) {
                swal({
                    title: "Lỗi",
                    text: $rootScope.arrayToList(data),
                    html: true,
                    type: "error"
                });
            });
    });

    //Update user roles
    $scope.updateUserRole = (function () {
        $http.post('/user/' + $scope.curUser.id + '/updateRole', $("form.editRoleForm").serializeArray())
            .success(function (data) {
                angular.forEach($scope.role, function (v, k) {
                    if($scope.role[k].id == data.id) {
                        $scope.role[k] = data;
                    }
                });
                swal({
                    title: "Cập nhật thành công",
                    type: "success"
                });
                $scope.cancel();
            })
            .error(function (data) {
                swal({
                    title: "Lỗi, không thể cập nhật quyền cho thành viên " + $scope.curUser.name,
                    type: "error"
                });
            })
    });

    // Instant search
    $scope.search = (function () {
        $http.post('/user/search', $scope.find)
            .success(function (data) {
                $scope.data = data;
            })
    });

    $scope.cancel = (function () {
        jQuery(".display").removeClass('display');
    });
});