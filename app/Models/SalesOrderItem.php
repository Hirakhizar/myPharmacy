<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SalesOrderItem extends Model
{
    use HasFactory;
    public function medicineItems(){
        return $this->belongsTo(Medicine::class,'item_id');
    }
    public function order()
    {
        return $this->belongsTo(SalesOrder::class,'order_id');
    }
 
}
