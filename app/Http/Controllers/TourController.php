<?php

namespace PYSCore\Http\Controllers;

use Illuminate\Http\Request;

use PYSCore\Http\Requests;
//use PYSCore\Http\Controllers\Controller;
use PYSCore\Tour;

class TourController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        return view('layouts.admin');
    }

    public function tourTemplate() {
        return view('tour.index');
    }

    public function store()
    {
        if(\Auth::user()->hasRole('add_tour')) {
            $data = \Request::all();
            $v = \Validator::make($data, [
                'tourid' => 'required|unique:tours,tourid',
                'tentour' => 'required',
                'gianguoilon' => 'required|min:0',
                'giatreem' => 'required|min:0'
            ], [
                'tourid.required' => 'Bạn cần nhập mã tour.',
                'tourid.unique' => 'Tour này đã được thêm từ trước.',
                'tentour.required' => 'Bạn cần nhập tên tour.',
                'gianguoilon.required' => 'Bạn cần nhập giá người lớn.',
                'gianguoilon.min' => 'Giá người lớn tối thiểu phải bằng 0.',
                'giatreem.required' => 'Bạn cần nhập giá trẻ em.',
                'giatreem.min' => 'Giá trẻ em tối thiểu phải bằng 0.',
            ]);
            if($v->fails()) {
                return \Response::make($v->errors(), 400);
            }
            $tour = new Tour();
            $tour->fill($data);
            $tour->save();
            return response($tour, 200);
        }
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->hasRole('update_tour')) {
            $data = $request->all();
            $v = \Validator::make($data, [
                'id' => 'exists:tours,id',
                'tourid' => 'required|unique:tours,tourid,' . $id,
                'tentour' => 'required',
                'gianguoilon' => 'required|min:0',
                'giatreem' => 'required|min:0'
            ], [
                'id.exists' => "Tour không tồn tại. Vui lòng tải lại trang",
                'tourid.required' => 'Bạn cần nhập mã tour.',
                'tourid.unique' => 'Tour này đã được thêm từ trước.',
                'tentour.required' => 'Bạn cần nhập tên tour.',
                'gianguoilon.required' => 'Bạn cần nhập giá người lớn.',
                'gianguoilon.min' => 'Giá người lớn tối thiểu phải bằng 0.',
                'giatreem.required' => 'Bạn cần nhập giá trẻ em.',
                'giatreem.min' => 'Giá trẻ em tối thiểu phải bằng 0.',
            ]);

            if($v->fails()) {
                return \Response::make($v->errors(), 400);
            }
            $tour = Tour::find($id);
            $tour->fill($data);
            $tour->save();
            return response($tour, 200);
        }
    }

    public function destroy($id)
    {
        if(\Auth::user()->hasRole('delete_tour')) {
            Tour::find($id)->delete();
            return \Response::make(array('Xóa thành công'), 200);
        }
        return redirect('/');
    }

    public function indexApi(){
        return \Response::json(Tour::all()->take(50));
    }

    public function search() {
        $str = \Request::all();
        $tentour = $str['tentour'];
        $tours = Tour::where('tentour', 'LIKE', '%' .$tentour. '%')
            ->take(50)->get();
        return \Response::make($tours, 200);
}
}
