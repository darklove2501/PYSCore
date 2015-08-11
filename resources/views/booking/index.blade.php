    <h1>Quản lý booking</h1>

    <p class="bg-success" ng-show="successMsg" ng-bind-html="successMsg"></p>
    <p class="bg-danger" ng-show="errorMsg" ng-bind-html="errorMsg"></p>
    <div class="row filterBlock">
        <div class="col-xs-2">
            <label>
                Tìm kiếm
                {{--<input class="form-control" type="text" ng-model="filter" placeholder="Nhập từ khóa cần lọc"/>--}}
                <input type="text" class="form-control" ng-change="searchBooking()" placeholder="Tìm kiếm booking" ng-model="searchString" ng-model-options="{ updateOn: 'default blur', debounce: {'default': 500, 'blur': 0} }"/>
            </label>
        </div>
        <div class="col-xs-2">
            <label>
                Lọc theo tour<br/>
                <select name="tour" id="tour" ng-model="tourfilter.tour_id" class="form-control">
                    <option ng-repeat="t in tour" value="@{{ t.id }}">@{{ t.tentour }}</option>
                </select>
            </label>
        </div>
        <div class="col-xs-8">
            @if(Auth::user()->hasRole('add_booking'))
            <a class="btn btn-success pull-right" href="" ng-click="addBooking()">Thêm booking mới</a>
            @endif
        </div>
    </div>
    <table id="TourTable" class="MainTable table table-striped">
        <thead>
            <tr>
                <td><a href="" ng-click="sortType='hoten'; sortReverse=!sortReverse;">Họ tên
                    <i class="fa fa-chevron-down" ng-show="sortType=='hoten' && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType=='hoten' && sortReverse"></i>
                </a></td>
                <td><a href="" ng-click="sortType='tour.tentour'; sortReverse=!sortReverse;">Tên tour
                    <i class="fa fa-chevron-down" ng-show="sortType=='tour.tentour' && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType=='tour.tentour' && sortReverse"></i>
                </a></td>
                <td><a href="" ng-click="sortType='ngaydi'; sortReverse=!sortReverse;">Ngày đi
                    <i class="fa fa-chevron-down" ng-show="sortType=='ngaydi' && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType=='ngaydi' && sortReverse"></i>
                </a></td>
                <td><a href="" ng-click="sortType='songuoilon'; sortReverse=!sortReverse;">Số người lớn
                    <i class="fa fa-chevron-down" ng-show="sortType=='songuoilon' && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType=='songuoilon' && sortReverse"></i>
                </a></td>
                <td><a href="" ng-click="sortType='sotreem'; sortReverse=!sortReverse;">Số trẻ em
                    <i class="fa fa-chevron-down" ng-show="sortType=='sotreem' && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType=='sotreem' && sortReverse"></i>
                </a></td>
                <td><a href="" ng-click="sortType=totalPrice; sortReverse=!sortReverse;">Tổng tiền
                    <i class="fa fa-chevron-down" ng-show="sortType==totalPrice && !sortReverse"></i>
                    <i class="fa fa-chevron-up" ng-show="sortType==totalPrice && sortReverse"></i>
                </a></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="x in data | filter:filter | filter:tourfilter:false | orderBy:sortType:sortReverse">
                <td>@{{ x.hoten }}</td>
                <td>@{{ x.tour.tentour }}</td>
                <td>@{{ x.ngaydi | date }}</td>
                <td>@{{ x.songuoilon | number }}</td>
                <td>@{{ x.sotreem | number }}</td>
                <td>@{{ x.songuoilon * x.tour.gianguoilon + x.sotreem * x.tour.giatreem | currency:"đ":0 }}</td>
                <td>
                    <a class="btn btn-primary" href="" data-ng-click="chitiet(x)">Chi tiết</a>
                    @if(Auth::user()->hasRole('update_booking'))
                    <a class="btn btn-warning" href="" data-ng-click="edit(x)">Sửa</a>
                    @endif
                    @if(Auth::user()->hasRole('delete_booking'))
                    <a class="btn btn-danger" href="" data-ng-click="delete(x)">Xóa</a>
                    @endif
                </td>
            </tr>
            <tr ng-if="data.length == 0">
                <td colspan="8">Không có booking nào</td>
            </tr>
        </tbody>
    </table>

<div class="popUp bookingForm">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2 ng-show="add">Thêm booking mới</h2>
        <h2 ng-hide="add">Sửa booking</h2>
        <form action="" class="row" id="addNewForm">
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="hoten">Họ và tên</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" ng-model="cur.hoten" placeholder="Nhập họ tên người đặt tour"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" ng-model="cur.email" placeholder="Nhập email khách hàng"/>
                </div>
                <div class="form-group">
                    <label for="sdt">Số điện thoại</label>
                    <input type="text" class="form-control" id="sdt" name="sdt" ng-model="cur.sdt" placeholder="Nhập số điện thoại"/>
                </div>
                <div class="form-group">
                    <label for="ngaydi">Ngày đi</label>
                    <input type="date" class="form-control" id="ngaydi" name="ngaydi" ng-model="cur.ngaydi" placeholder=""/>
                </div>
                <div class="form-group">
                    <label for="diachi">Địa chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" ng-model="cur.diachi" placeholder="Nhập địa chỉ người đặt tour"/>
                </div>
                <div class="form-group">
                    <label>Hình thức thanh toán</label>
                    <label><input type="radio" name="thanhtoan" ng-model="cur.thanhtoan" value="0"/> Chuyển khoản ngân hàng</label>
                    <label><input type="radio" name="thanhtoan" ng-model="cur.thanhtoan" value="1"/> Đến văn phòng PYS</label>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="songuoilon">Số người lớn</label>
                            <input type="number" min="1" name="songuoilon" ng-model="cur.songuoilon" id="songuoilon" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="sotreem">Số trẻ em</label>
                            <input type="number" min="0" name="sotreem" ng-model="cur.sotreem" id="sotreem" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="yeucau">Yêu cầu đặc biệt</label>
                    <textarea name="yeucau" id="yeucau" rows="4" class="form-control" ng-model="cur.yeucau"></textarea>
                </div>
                <div class="form-group">
                    <label for="ghichu">Ghi chú</label>
                    <textarea name="ghichu" id="ghichu" rows="4" class="form-control" ng-model="cur.ghichu"></textarea>
                </div>
                <div class="form-group">
                    <label for="tour_id">Chọn tour</label>
                    <select name="tour_id" ui-select2 theme="select2" id="tour_id" class="select2" ng-model="cur.tour_id">
                        <option ng-repeat="t in tour" value="@{{ t.id }}" ng-selected="@{{ cur.tour_id==t.id }}">@{{ t.tentour }}</option>
                    </select>
                </div>
                <a class="btn btn-primary" href="" ng-click="update()" ng-hide="-add">Cập nhật</a>
                <a class="btn btn-success" href="" ng-click="postNew()" ng-show="add">Thêm mới</a>
                <a class="btn btn-warning" href="" ng-click="cancel()">Thôi</a>
            </div>
        </form>
    </div>
</div>

<div class="popUp chiTietBooking">
    <div class="back" ng-click="cancel()"></div>
    <div class="front">
        <h2>Chi tiết booking</h2>
        <div class="row">
            <div class="col-xs-4">
                <h3><strong>Họ tên:</strong> @{{ cur.hoten }}</h3>
                <p><strong>Email:</strong> @{{ cur.email }}</p>
                <p><strong>Số điện thoại:</strong> @{{ cur.sdt }}</p>
                <p><strong>Ngày đi tour:</strong> @{{ cur.ngaydi }}</p>
                <p ng-switch="cur.thanhtoan"><strong>Hình thức thanh toán: </strong>
                    <span ng-switch-when="0">Chuyển khoản ngân hàng</span>
                    <span ng-switch-when="1">Đến văn phòng PYS</span>
                </p>
            </div>
            <div class="col-xs-4">
                <p><strong>Số người lớn:</strong> @{{ cur.songuoilon }}</p>
                <p><strong>Số trẻ em:</strong> @{{ cur.sotreem }}</p>
                <p><strong>Yêu cầu đặc biệt:</strong> <br/>@{{ cur.yeucau }}</p>
                <p><strong>Ghi chú:</strong> <br/>@{{ cur.ghichu }}</p>
            </div>
            <div class="col-xs-4">
                <p><strong>Tên tour:</strong> @{{ cur.tour.tentour }}</p>
                <p><strong>Tổng giá trẻ em:</strong> @{{ cur.sotreem * cur.tour.giatreem | number }}</p>
                <p><strong>Tổng giá người lớn:</strong> @{{ cur.songuoilon * cur.tour.gianguoilon | number }}</p>
                <p><strong>Tổng cộng:</strong> @{{ cur.sotreem * cur.tour.giatreem + cur.songuoilon * cur.tour.gianguoilon | number }}</p>
            </div>
        </div>
    </div>
</div>