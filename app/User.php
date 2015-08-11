<?php

namespace PYSCore;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * PYSCore\User
 *
 */
class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function roles() {
        return $this->belongsToMany('PYSCore\Role', 'users_roles');
    }

    public function hasRole($check) {
        return in_array($check, fetch_the_array($this->roles->toArray(), 'name'));
    }

    public function getRoleId($array, $term) {
        foreach($array as $k => $v) {
            if($v['name'] == $term) {
                return $v['id'];
            }
        }
        throw new \UnexpectedValueException;
    }

    public function makeRole($title)
    {
        $roles = Role::all()->toArray();

        switch ($title) {
            case 'super_admin':
                $assigned_roles[] = Role::where('name', '=', 'update_user_role')->first()->id;
            case 'admin':
                $assigned_roles[] = Role::where('name', '=', 'add_user')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'update_user')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'delete_user')->first()->id;
            case 'editor':
                $assigned_roles[] = Role::where('name', '=', 'add_tour')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'update_tour')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'delete_tour')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'add_booking')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'update_booking')->first()->id;
                $assigned_roles[] = Role::where('name', '=', 'delete_booking')->first()->id;
                break;
            default:
                throw new \Exception("Trạng thái của nhân viên này không tồn tại");
        }
        $this->roles()->attach($assigned_roles);
    }

    public function isStaff() {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
}
