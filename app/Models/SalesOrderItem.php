<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;
    public function medicine(){
        return $this->belongsTo(Medicine::class,'cart_id');
    }
}
