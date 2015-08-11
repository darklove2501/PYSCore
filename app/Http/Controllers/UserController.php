<?php

namespace PYSCore\Http\Controllers;

use PYSCore\User;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndexTemplate() {
        return view('user.index');
    }

    public function getAllUser() {
        return User::all();
    }

    public function postNew() {
        if(\Auth::user()->hasRole('add_user')) {

            $data = \Request::all();
            $v = \Validator::make($data, array(
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ), array(
                'name.required' => 'Bạn cần nhập tên người dùng',
                'email.unque' => 'Email này đã có người đăng ký',
                'email.required' => 'Bạn cần nhập địa chỉ email',
                'email.email' => 'Email bạn nhập chưa đúng định dạng',
                'password.required' => 'Bạn cần nhập mật khẩu',
                'password.min' => 'Mật khẩu cần tối thiểu 8 ký tự',
            ));
            $err = array_object_to_array($v->errors()->toArray());
            $same = true;
            if($data['password'] != $data['repassword']) {
                $err[] = 'Mật khẩu xác nhận không trùng';
                $same = false;
            }
            if($v->fails() || !$same) {
                return \Response::make($err, 400);
            }

            $user = new User();
            $user->name = trim($data['name']);
            $user->email = trim($data['email']);
            $user->password = \Hash::make($data['password']);
            $user->save();

            return response($user, 200);
        }
        return response(array("Bạn không có quyền thêm thành viên"), 400);
    }

    public function update($id) {
        if(\Auth::user()->hasRole('update_user')) {

            $data = \Request::all();
            $v = \Validator::make($data, array(
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id
            ),array(
                'name.required' => 'Bạn cần nhập tên người dùng',
                'email.unque' => 'Email này đã có người đăng ký',
                'email.required' => 'Bạn cần nhập địa chỉ email',
                'email.email' => 'Email bạn nhập chưa đúng định dạng',
            ));

            if($v->fails()) {
                return response($v->errors(), 400);
            }

            $user = User::find($id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->save();

            return response($user, 200);
        }
        return response(array("Bạn không có cập nhật thành viên"));
    }

    public function updatePassword($id) {
        if(\Auth::user()->hasRole('update_user')) {
            $data = \Request::all();
            $v = \Validator::make($data, array(
                'password' => 'required|min:8'
            ), array(
                'password.required' => 'Bạn cần nhập mật khẩu',
                'password.min' => 'Mật khẩu cần tối thiểu 8 ký tự',
            ));
            $err = $v->errors()->toArray();
            $same = true;
            if($data['password'] != $data['repassword']) {
                $err[] = 'Mật khẩu xác nhận không trùng';
                $same = false;
            }
            if($v->fails() || !$same) {
                return \Response::make($err, 400);
            }

            $user = User::findOrFail($id);
            $user->password = \Hash::make($data['password']);
            $user->save();

            return response($user, 200);
        }
        return response(array("Bạn không có quyền cập nhật thành viên"), 400);
    }

    public function delete($id) {
        if(\Auth::user()->hasRole('delete_user')) {
            $user = User::find($id);
            if(\Auth::user()->id == $id) {
                return response(array("Bạn không thể xóa chính mình"), 400);
            }

            if($user->hasRole('delete_user')) {
                return response(array("Bạn không thể xóa quản trị viên cấp cao"), 400);
            }

            User::destroy($id);
            return response("Xóa thành công!");
        }
        return response(array("Bạn không có quyền xóa thành viên"), 400);
    }

    public function search() {
        $req = \Request::all();
        $output = User::where('name', 'LIKE', '%'.$req['user']. '%')
            ->orWhere('email', 'LIKE', '%'.$req['user'] . '%')->get();
        return $output;
    }

    public function getUserRole($id) {
        return User::find($id)->roles;
    }

    public function updateRole($id){
        $data = \Request::all();
        \DB::table('users_roles')->where('user_id', '=', $id)->delete();
        foreach($data as $k => $v) {
            User::find($id)->roles()->attach($v["value"]);
        }
        return response("Cập nhật thành công", 200);
    }
}