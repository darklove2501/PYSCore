    <h1>Quản lý người dùng</h1>

    <p class="bg-success" ng-show="successMsg" ng-bind-html="successMsg"></p>
    <p class="bg-danger" ng-show="errorMsg" ng-bind-html="errorMsg"></p>

    <div class="row filterBlock">
        <div class="col-xs-6">
            <label>
                Tìm kiếm
                {{--<input class="form-control" type="text" ng-model="filter" placeholder="Nhập từ khóa cần lọc"/>--}}
                <input type="text" class="form-control" ng-model="find.user" ng-model-options="{ debounce: 500 }" ng-change="search()" placeholder="Nhập tên người dùng hoặc email cần tìm" />
            </label>
        </div>
        <div class="col-xs-offset-2 col-xs-4">
            @if(Auth::user()->hasRole('add_user'))
            <a class="btn btn-success pull-right" href="" ng-click="addUser()">Thêm người dùng mới</a>
            @endif
        </div>
    </div>
    <table id="UserTable" class="MainTable table table-striped">
        <thead>
            <tr>
                <td>Tên người dùng</td>
                <td>Email</td>
                <td>Ngày tham gia</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in data | filter:filter | orderBy:'-id'">
                <td>@{{ x.name }}</td>
                <td>@{{ x.email }}</td>
                <td>@{{ x.created_at }}</td>
                <td>
                    @if(Auth::user()->hasRole('update_user_role'))
                    <a href="" class="btn btn-danger" data-ng-click="editRole(x)">Quyền hạn</a>
                    @endif
                    @if(Auth::user()->hasRole('update_user'))
                    <a class="btn btn-info" href="" data-ng-click="edit(x)">Sửa</a>
                    <a class="btn btn-warning" href="" data-ng-click="editPassword(x)">Đổi mật khẩu</a>
                    @endif
                    @if(Auth::user()->hasRole('delete_user'))
                    <a class="btn btn-danger" href="" data-ng-click="delete(x)">Xóa</a>
                    @endif
                </td>
            </tr>
            <tr ng-if="data.length == 0">
                <td colspan="4">Không có người dùng nào</td>
            </tr>
        </tbody>
    </table>

@if(Auth::user()->hasRole('add_user'))
<div class="popUp addUserForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2>Thêm người dùng mới</h2>
        <form action="{{ url('user/postNew') }}" method="post" class="addNewForm">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input class="form-control" type="text" name="name" id="name" ng-model="newUser.name"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" ng-model="newUser.email"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password" ng-model="newUser.password"/>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Nhập lại mật khẩu</label>
                        <input class="form-control" type="password" name="repassword" id="repassword" ng-model="newUser.repassword"/>
                    </div>
                    <a class="btn btn-primary" ng-click="postNew()" href="" id="submit">Thêm thành viên mới</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@if(Auth::user()->hasRole('update_user'))
<div class="popUp editUserForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2>Sửa thông tin @{{ editUser.name }}</h2>
        <form action="{{ url('user/update') }}" method="post" class="editForm">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                        <label for="name">Tên người dùng</label>
                        <input class="form-control" type="text" name="name" id="name" ng-model="editUser.name"/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" ng-model="editUser.email"/>
                    </div>
                    <a class="btn btn-primary" ng-click="updateUser()" href="" id="submit">Sửa thông tin</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popUp editPasswordForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2>Cập nhật mật khẩu người dùng @{{ editUser.name }}</h2>
        <form action="{{ url('user/updatePassword') }}" method="post" class="editPasswordForm">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-group">
                        <label for="password">Mật khẩu mới</label>
                        <input class="form-control" type="password" name="password" id="password" ng-model="editUser.password"/>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Nhập lại mật khẩu</label>
                        <input class="form-control" type="password" name="repassword" id="repassword" ng-model="editUser.repassword"/>
                    </div>
                    <a class="btn btn-primary" ng-click="updateUserPassword()" href="" id="submit">Đổi mật khẩu</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@if(Auth::user()->hasRole('update_user_role'))
<div class="popUp editRoleForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2>Thay đổi quyền hạn cho @{{ editUser.name }}</h2>
        <form action="{{ url('user/updatePassword') }}" method="post" class="editRoleForm">
            <div class="row">
                {{--<label class="col-xs-3" ng-repeat="(k, v) in role | orderBy:'id'" ng-click="curRoleId[k]">--}}
                    {{--<input type="checkbox" ng-checked="curRoleId.indexOf(v.id) > -1" value="v.name"/> @{{ v.name }}--}}
                {{--</label>--}}
                <label class="col-xs-3"  ng-repeat="(k, v) in role | orderBy:'id'">
                    <input type="checkbox" name="roles[]" value="@{{ v.id }}" ng-checked="roleId[v.id]"/> @{{ v.name }}
                </label>
            </div>
            <a href="" class="btn btn-primary" ng-click="updateUserRole(x)">Cập nhật</a>
            <a href="" class="btn" ng-click="cancel()">Thôi</a>
        </form>
    </div>
</div>
@endif