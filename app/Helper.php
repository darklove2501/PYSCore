<?php
use PYSCore\User;


//Check if user can add, update or delete another users
function canModifyUser($id = '') {
    if($id == '') {
        if(Auth::user()->hasRole('add_user') || Auth::user()->hasRole('update_user') || Auth::user()->hasRole('delete_user')) {
            return true;
        }
        return false;
    }
    if(User::find($id)->hasRole('add_user') || User::find($id)->hasRole('update_user') ||User::find($id)->hasRole('delete_user')) {
        return true;
    }
    return false;
}

//Check if user can add, update or delete tours
function canModifyTour($id = '') {
    if($id == '') {
        if(Auth::user()->hasRole('add_tour') || Auth::user()->hasRole('update_tour') || Auth::user()->hasRole('delete_tour')) {
            return true;
        }
        return false;
    }
    if(User::find($id)->hasRole('add_tour') || User::find($id)->hasRole('update_tour') ||User::find($id)->hasRole('delete_tour')) {
        return true;
    }
    return false;
}

//Check if user can add, update or delete bookings
function canModifyBooking($id ='') {
    if($id == '') {
        if(Auth::user()->hasRole('add_booking') || Auth::user()->hasRole('update_booking') || Auth::user()->hasRole('delete_booking')) {
            return true;
        }
        return false;
    }
    if(User::find($id)->hasRole('add_booking') || User::find($id)->hasRole('update_booking') ||User::find($id)->hasRole('delete_booking')) {
        return true;
    }
    return false;
}

/**
 * @param $array
 * @param $type
 * @return array
 */
function fetch_the_array($array, $type){
    $new = array();
    foreach($array as $k => $v) {
        $new[$v['id']] = $v[$type];
    }
    return $new;
}

function array_object_to_array($array) {
    $op = array();
    foreach($array as $k => $v) {
        $op[] = (array)$v;
    }
    return $op;
}