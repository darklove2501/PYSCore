<?php

namespace PYSCore;

//use Illuminate\Database\Eloquent\Model;

class Booking extends \Eloquent
{

    protected $table = 'bookings';

    public $fillable = ['ngaydi', 'hoten', 'email', 'sdt', 'diachi', 'yeucau', 'thanhtoan', 'ghichu', 'tour_id', 'songuoilon', 'sotreem'];

    public $timestamps = true;

    protected $hidden = ['created_at', 'updated_at'];

    public function Tour() {
        return $this->belongsTo('PYSCore\Tour', 'tour_id');
    }
}
