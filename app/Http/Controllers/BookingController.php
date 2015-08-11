<?php

namespace PYSCore\Http\Controllers;

use Illuminate\Http\Request;

use PYSCore\Booking;
use PYSCore\Http\Requests;

class BookingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('layouts.admin');
    }

    public function bookingTemplate() {
        return view('booking.index');
    }

    public function store(Request $request)
    {
        if(\Auth::user()->hasRole('add_booking')) {
            $v = \Validator::make($request->all(), [
                'hoten' => 'required',
                'tour_id' => 'required',
                'ngaydi' => 'date',
                'email' => 'email',
                'thanhtoan' => 'required',
                'songuoilon' => 'min:1',
                'sotreem' => 'min:0'
            ],[
                'hoten.required' => 'Bạn chưa nhập họ tên',
                'tour_id.required' => 'Vui lòng chọn tour muốn đi',
                'ngaydi.date' => 'Vui lòng chọn đúng định dạng ngày',
                'email.email' => 'Email sai',
                'thanhtoan.required' => 'Cần có phương thức thanh toán',
                'songuoilon.min' => 'Số người lớn tối thiểu phải bằng 1',
                'sotreem.min' => 'Số trẻ em tối thiểu phải bằng 0'
            ]);
            if($v->fails()) {
                return \Response::make($v->errors(), 400);
            }
            $b = new Booking();
            $b->fill($request->all());
            $b->save();
            $b['tour'] = $b->Tour;
            return response($b, 200);
        }
        return redirect('/');
    }

    public function show($id)
    {
        return redirect('/');
    }

    public function getByTour() {
        $booking = Booking::where('tour_id', '=', (int)\Request::get('tourId'))->get();
        foreach($booking as $b) {
            $b['tour'] = $b->Tour;
        }
        return $booking;
    }

    public function update(Request $request, $id)
    {
        if(\Auth::user()->hasRole('update_booking')) {
            $data = $request->all();
            $v = \Validator::make($data, [
                'hoten' => 'required',
                'tour_id' => 'required',
                'ngaydi' => 'date',
                'email' => 'email',
                'thanhtoan' => 'required',
                'songuoilon' => 'min:1',
                'sotreem' => 'min:0'
            ], [
                'hoten.required' => 'Bạn chưa nhập họ tên',
                'tour_id.required' => 'Vui lòng chọn tour muốn đi',
                'ngaydi.date' => 'Vui lòng chọn đúng định dạng ngày',
                'email.email' => 'Email sai',
                'thanhtoan.required' => 'Cần có phương thức thanh toán',
                'songuoilon.min' => 'Số người lớn tối thiểu phải bằng 1',
                'sotreem.min' => 'Số trẻ em tối thiểu phải bằng 0'
            ]);
            if ($v->fails()) {
                return \Response::make($v->errors(), 400);
            }
            $b = Booking::find($id);
            $b->fill($data);
            $b->save();
            $b['tour'] = $b->Tour;
            return response($b, 200);
        }
        return redirect('/');
    }

    public function destroy($id)
    {
        if(\Auth::user()->hasRole('delete_user')) {
            $v = \Validator::make(['id' => $id], [
                'id' => 'required'
            ],[
                'id.required' => 'Không có booking nào để xóa',
            ]);
            if($v->fails()) {
                return \Response::make($v->errors(), 400);
            }
            return Booking::destroy($id);
        }
        return redirect('/');
    }

    public function indexApi() {
        $data = Booking::all()->take(20);
        $data2 = $data->toArray();
        foreach($data2 as $k => $v) {
            $v[] = $data[$k]->Tour;
        }
        return $data;
    }


    public function searchApi() {
        $request = \Request::all();
        $searchString = $request['searchString'];
        $data = Booking::where('hoten', 'LIKE', "%$searchString%")
            ->orWhere('ghichu', 'LIKE', "%$searchString%")
            ->get();
        $data2 = $data->toArray();
        foreach ($data2 as $k => $v) {
            $v[] = $data[$k]->Tour;
        }
        return $data;
    }
}
