<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getPhotoAttribute($photo){
        if($photo){
            return asset('public/storage/'. $photo);
        }else{
            return '';
        }
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class , 'user_id');
    }



}
