<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'emp_group', 'user_id', 'group_id');
    }

}
