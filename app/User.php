<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //Shows the fields in the table that can be filled from the system
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    //Shows the fields in the table that are hidden in system
    protected $hidden = [
        'password', 'remember_token',
    ];

    //A role has many users
    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    //A user has many surveys
    public function survey()
    {
        return $this->hasMany('App\Survey');
    }

    public function hasRole($role) {
        if (is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    /*
     *  assign a role to a user
     */
    public function assignRole($role) {
        return $this->roles()->sync(
            Role::whereName($role)->firstOrFail()
        );
    }}
