<?php

namespace PYSCore;

//use Illuminate\Database\Eloquent\Model;

class Tour extends \Eloquent
{
    public $table = 'tours';

    public $timestamps = false;

    protected $fillable = ['tourid', 'tentour', 'thoigian', 'nguoilon', 'gianguoilon', 'giatreem', 'ghichu'];

    public function Booking() {
        return $this->hasMany('Booking');
    }
}
