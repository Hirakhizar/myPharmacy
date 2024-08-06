<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendece;

class Member extends Model
{
    use HasFactory;

    public function attendence(){
        return $this->hasMany(Attendence::class,'member_id');
    }
    public function salaries()
    {
        return $this->hasMany(MemberSalary::class,'member_id');
    }
}


