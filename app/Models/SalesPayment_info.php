<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPayment_info extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(SalesOrder::class,'order_id');
    }
}
