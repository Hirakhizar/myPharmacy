<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function payments()
    {
        return $this->hasMany(SalesPayment_info::class,'order_id');
    }
}
