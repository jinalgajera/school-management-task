<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    protected $fillable = ['user_id', 'phone', 'gender', 'address', 'qualification', 'experience', 'joining_date', 'profile_photo', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
