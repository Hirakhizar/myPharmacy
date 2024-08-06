<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;
    public function salesInfo()
    {
        return $this->hasMany(SalesPayment_info::class,'order_id');
    }
}
    

