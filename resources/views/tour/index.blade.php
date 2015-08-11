    <h1>Quản lý tour</h1>

    <p class="bg-success" ng-show="successMsg" ng-bind-html="successMsg"></p>
    <p class="bg-danger" ng-show="errorMsg" ng-bind-html="errorMsg"></p>

    <div class="row filterBlock">
        <div class="col-xs-4">
            <label>
                Tìm kiếm
                {{--<input class="form-control" type="text" ng-model="filter" placeholder="Nhập từ khóa cần lọc"/>--}}
                <input type="text" class="form-control" ng-model="find.tentour" ng-model-options="{ debounce: 500 }" ng-change="search()" placeholder="Nhập tên tour cần tìm" />
            </label>
        </div>
        <div class="col-xs-offset-4 col-xs-4">
            @if(Auth::user()->hasRole('add_tour'))
            <a class="btn btn-success pull-right" href="" ng-click="addTour()">Thêm tour mới</a>
            @endif
        </div>
    </div>
    <table id="TourTable" class="MainTable table table-striped">
        <thead>
            <tr>
                <td>Tên Tour</td>
                <td>Mã Tour</td>
                <td>Thời gian</td>
                <td>Giá người lớn</td>
                <td>Giá trẻ em</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in data | filter:filter | orderBy:'-id'">
                <td>@{{ x.tentour }}</td>
                <td>@{{ x.tourid }}</td>
                <td>@{{ x.thoigian }}</td>
                <td>@{{ x.gianguoilon | number }}</td>
                <td>@{{ x.giatreem | number }}</td>
                <td>
                    @if(canModifyBooking())
                    <a class="btn btn-primary" href="/booking/tour/@{{ x.id }}">Bookings</a>
                    @endif
                    @if(Auth::user()->hasRole('update_tour'))
                        <a class="btn btn-info" href="" data-ng-click="edit(x)">Sửa</a>
                    @endif
                    @if(Auth::user()->hasRole('delete_tour'))
                        <a class="btn btn-danger" href="" data-ng-click="delete(x)">Xóa</a>
                    @endif
                </td>
            </tr>
            <tr ng-if="data.length == 0">
                <td colspan="7">Không có tour nào</td>
            </tr>
        </tbody>
    </table>

<div class="popUp tourForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2 ng-show="add">Thêm tour mới</h2>
        <h2 ng-hide="add">Sửa tour</h2>
        <form action="" class="row" id="addNewForm" name="addUserForm">
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="tentour">Tên tour</label>
                    <input type="text" class="form-control" id="tentour" name="tentour" ng-model="cur.tentour" placeholder="Nhập tên tour" ng-minlength="2" ng-maxlength="255" required/>
                    <div class="ng-message" ng-messages="addUserForm.tentour.$error" ng-if="addUserForm.tentour.$touched">
                        <div ng-messages-include="/angularValidationMessages"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tourid">Mã tour</label>
                    <input type="text" class="form-control" id="tourid" name="tourid" ng-model="cur.tourid" placeholder="Nhập mã tour" ng-maxlength="6" required/>
                    <div class="ng-message" ng-messages="addUserForm.tourid.$error" ng-if="addUserForm.tourid.$touched">
                        <div ng-messages-include="/angularValidationMessages"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="thoigian">Thời gian</label>
                    <input type="text" class="form-control" id="thoigian" name="thoigian" ng-model="cur.thoigian" placeholder="Nhập thời gian tour"/>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="gianguoilon">Giá người lớn</label>
                    <input type="number" class="form-control" id="gianguoilon" name="gianguoilon" ng-init="cur.gianguoilon = 0;" ng-model="cur.gianguoilon" step="1000"  placeholder="Nhập giá người lớn" ng-minlength="0" min="0" required/>
                    <div class="ng-message" ng-messages="addUserForm.gianguoilon.$error" ng-if="addUserForm.gianguoilon.$touched">
                        <div ng-messages-include="/angularValidationMessages"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="giatreem">Giá trẻ em</label>
                    <input type="number" class="form-control" id="giatreem" name="giatreem" ng-init="cur.giatreem = 0;" ng-model="cur.giatreem" step="1000" placeholder="Nhập giá người lớn" ng-minlength="0" min="0" required/>
                    <div class="ng-message" ng-messages="addUserForm.giatreem.$error" ng-if="addUserForm.giatreem.$touched">
                        <div ng-messages-include="/angularValidationMessages"></div>
                    </div>
                </div>
                <a class="btn btn-primary" href="" ng-click="update()" ng-hide="-add">Cập nhật</a>
                <a class="btn btn-success" href="" ng-click="postNew()" ng-show="add">Thêm mới</a>
                <a class="btn btn-warning" href="" ng-click="cancel()">Thôi</a>
            </div>
        </form>
    </div>
</div>