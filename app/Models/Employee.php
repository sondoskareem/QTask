<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends User
{
    use HasFactory;
    protected $table = 'users';
    protected $with = 'groups:name';


    public function permits()
    {
        return $this->hasMany(Permit::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'emp_group', 'user_id', 'group_id');
    }
}
